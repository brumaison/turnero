<?php
namespace App\Models;

use App\Core\Model;

class Turno extends Model {
    protected static $table = 'turnos';

    public static function getHoy() {
        $stmt = self::db()->prepare("
            SELECT t.*, p.nombre, p.apellido, p.dni, pr.nombre as profesional
            FROM turnos t
            JOIN pacientes p ON t.paciente_id = p.id
            JOIN profesionales pr ON t.profesional_id = pr.id
            WHERE DATE(t.fecha_hora) = CURDATE()
            ORDER BY t.fecha_hora ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public static function getHorariosPorEspecialidad($especialidad_id, $fecha_desde, $dias = 7) {
    $db = self::db();
    
    // Obtener profesionales con esta especialidad
    $stmt = $db->prepare("
        SELECT p.id, p.nombre 
        FROM profesionales p
        INNER JOIN profesional_especialidad pe ON p.id = pe.profesional_id
        WHERE pe.especialidad_id = ?
    ");
    $stmt->execute([$especialidad_id]);
    $profesionales = $stmt->fetchAll();

    if (empty($profesionales)) return [];

    $resultado = [];
    
    foreach ($profesionales as $prof) {
        for ($i = 0; $i < $dias; $i++) {
            $fecha = date('Y-m-d', strtotime($fecha_desde . " +$i days"));
            $horarios = \App\Models\Agenda::getHorariosDisponibles($prof['id'], $fecha);

            foreach ($horarios as $hora) {
                $resultado[] = [
                    'profesional_id' => $prof['id'],
                    'profesional_nombre' => $prof['nombre'],
                    'fecha' => $fecha,
                    'fecha_label' => carbon_date($fecha)->translatedFormat('l d/m'),
                    'hora' => $hora,
                    'fecha_hora' => $fecha . ' ' . $hora
                ];
            }
        }
    }

    usort($resultado, fn($a, $b) => strcmp($a['fecha_hora'], $b['fecha_hora']));
    return array_slice($resultado, 0, 20);
}

    public static function getRango($fecha_inicio, $fecha_fin, $profesional_id = null) {
        if ($profesional_id) {
            $stmt = self::db()->prepare("
                SELECT t.*, 
                        p.nombre, p.apellido, p.dni, 
                        pr.nombre as profesional,
                        c.nombre as consultorio_nombre
                FROM turnos t
                JOIN pacientes p ON t.paciente_id = p.id
                JOIN profesionales pr ON t.profesional_id = pr.id
                LEFT JOIN consultorios c ON t.consultorio_id = c.id
                WHERE DATE(t.fecha_hora) BETWEEN ? AND ?
                AND t.profesional_id = ?
                ORDER BY t.fecha_hora ASC
            ");
            $stmt->execute([$fecha_inicio, $fecha_fin, $profesional_id]);
        } else {
            $stmt = self::db()->prepare("
                SELECT t.*, 
                        p.nombre, p.apellido, p.dni, 
                        pr.nombre as profesional,
                        c.nombre as consultorio_nombre
                FROM turnos t
                JOIN pacientes p ON t.paciente_id = p.id
                JOIN profesionales pr ON t.profesional_id = pr.id
                LEFT JOIN consultorios c ON t.consultorio_id = c.id
                WHERE DATE(t.fecha_hora) BETWEEN ? AND ?
                ORDER BY t.fecha_hora ASC
            ");
            $stmt->execute([$fecha_inicio, $fecha_fin]);
        }
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $stmt = self::db()->prepare("
            SELECT t.*, 
                p.nombre, p.apellido, p.dni, p.email, p.telefono,
                pr.nombre as profesional,
                c.nombre as consultorio_nombre
            FROM turnos t
            JOIN pacientes p ON t.paciente_id = p.id
            JOIN profesionales pr ON t.profesional_id = pr.id
            LEFT JOIN consultorios c ON t.consultorio_id = c.id
            WHERE t.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create($data) {
        //var_dump($data);
        //exit;
        $stmt = self::db()->prepare("
            INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, observaciones, estado_id, duracion_minutos, sobreturno)
            VALUES (:paciente_id, :profesional_id, :consultorio_id, :fecha_hora, :observaciones, :estado_id, :duracion_minutos, :sobreturno)
        ");
        return $stmt->execute($data);
    }

    public static function update($id, $data) {
        $stmt = self::db()->prepare("
            UPDATE turnos 
            SET paciente_id = :paciente_id, 
                profesional_id = :profesional_id, 
                consultorio_id = :consultorio_id, 
                fecha_hora = :fecha_hora, 
                observaciones = :observaciones, 
                estado_id = :estado_id,
                duracion_minutos = :duracion_minutos,
                sobreturno = :sobreturno
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public static function getConsultorios() {
        $stmt = self::db()->query("SELECT id, nombre FROM consultorios ORDER BY nombre");
        return $stmt->fetchAll();
    }

    // 🔹 MEJORADO: Valida solapamiento real considerando duración
    public static function existeSuperposicion($profesional_id, $fecha_hora, $duracion_minutos = 30, $excluir_turno_id = null) {
        $nuevo_inicio = $fecha_hora;
        $nuevo_fin = date('Y-m-d H:i:s', strtotime($fecha_hora . " +$duracion_minutos minutes"));
        
        $sql = "
            SELECT COUNT(*) FROM turnos 
            WHERE profesional_id = :profesional_id 
            AND DATE(fecha_hora) = DATE(:nuevo_inicio)
            AND estado_id NOT IN (3, 4, 5)
        ";
        
        $params = [
            'profesional_id' => $profesional_id,
            'nuevo_inicio' => $nuevo_inicio
        ];
        
        if ($excluir_turno_id) {
            $sql .= " AND id != :excluir_id";
            $params['excluir_id'] = $excluir_turno_id;
        }
        
        $sql .= "
            AND (
                fecha_hora < :nuevo_fin 
                AND DATE_ADD(fecha_hora, INTERVAL duracion_minutos MINUTE) > :nuevo_inicio
            )
        ";
        
        $params['nuevo_fin'] = $nuevo_fin;
        
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public static function updateEstado($id, $estado_id) {
        $stmt = self::db()->prepare("UPDATE turnos SET estado_id = :estado_id WHERE id = :id");
        return $stmt->execute(['estado_id' => $estado_id, 'id' => $id]);
    }

    public static function getEstadosConColor() {
        $stmt = self::db()->query("SELECT id, nombre, color FROM estados_turno ORDER BY id");
        return $stmt->fetchAll();
    }
}
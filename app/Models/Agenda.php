<?php
namespace App\Models;

use App\Core\Model;

class Agenda extends Model {
    protected static $table = 'agendas';

    public static function getByProfesional($profesional_id) {
        $stmt = self::db()->prepare("
            SELECT * FROM agendas 
            WHERE profesional_id = ? AND activo = 1
            ORDER BY dia_semana, hora_inicio
        ");
        $stmt->execute([$profesional_id]);
        return $stmt->fetchAll();
    }

    // 🔹 NUEVO: Obtener agenda configurada para un profesional en un día específico
    public static function getByProfesionalYDia($profesional_id, $dia_semana) {
        $stmt = self::db()->prepare("
            SELECT * FROM agendas 
            WHERE profesional_id = ? 
            AND dia_semana = ? 
            AND activo = 1
            LIMIT 1
        ");
        $stmt->execute([$profesional_id, $dia_semana]);
        return $stmt->fetch() ?: null;
    }

    public static function estaDisponible($profesional_id, $fecha_hora, $duracion_minutos = 30, $excluir_turno_id = null) {
        $datetime = new \DateTime($fecha_hora);
        $dia_semana = (int)$datetime->format('N');
        $hora = $datetime->format('H:i:s');
        $hora_fin_turno = date('H:i:s', strtotime($hora) + ($duracion_minutos * 60));
        
        $stmt = self::db()->prepare("
            SELECT * FROM agendas 
            WHERE profesional_id = ? 
            AND dia_semana = ? 
            AND activo = 1
            AND hora_inicio <= ? 
            AND hora_fin >= ?
        ");
        $stmt->execute([$profesional_id, $dia_semana, $hora, $hora_fin_turno]);
        $agenda = $stmt->fetch();
        
        if (!$agenda) {
            return false;
        }
        
        $sql = "
            SELECT COUNT(*) FROM turnos 
            WHERE profesional_id = ? 
            AND fecha_hora = ?
            AND estado_id NOT IN (3, 4)
        ";
        $params = [$profesional_id, $fecha_hora];
        
        if ($excluir_turno_id) {
            $sql .= " AND id != ?";
            $params[] = $excluir_turno_id;
        }
        
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        $turnos_existentes = $stmt->fetchColumn();
        
        return $turnos_existentes == 0;
    }

    public static function getHorariosDisponibles($profesional_id, $fecha) {
        $datetime = new \DateTime($fecha);
        $dia_semana = (int)$datetime->format('N');
        
        $stmt = self::db()->prepare("
            SELECT * FROM agendas 
            WHERE profesional_id = ? 
            AND dia_semana = ? 
            AND activo = 1
        ");
        $stmt->execute([$profesional_id, $dia_semana]);
        $agendas = $stmt->fetchAll();
        
        if (empty($agendas)) {
            return [];
        }
        
        $stmt = self::db()->prepare("
            SELECT fecha_hora FROM turnos 
            WHERE profesional_id = ? 
            AND DATE(fecha_hora) = ?
            AND estado_id NOT IN (3, 4)
        ");
        $stmt->execute([$profesional_id, $fecha]);
        $turnos_ocupados = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        
        $horarios = [];
        foreach ($agendas as $agenda) {
            $inicio = strtotime($agenda['hora_inicio']);
            $fin = strtotime($agenda['hora_fin']);
            $duracion = $agenda['duracion_minutos'] * 60;
            
            while ($inicio + $duracion <= $fin) {
                $hora_turno = date('H:i', $inicio);
                $fecha_hora_completa = $fecha . ' ' . $hora_turno . ':00';
                
                if (!in_array($fecha_hora_completa, $turnos_ocupados)) {
                    $horarios[] = $hora_turno;
                }
                
                $inicio += $duracion;
            }
        }
        
        return $horarios;
    }

    public static function create($data) {
        $stmt = self::db()->prepare("
            INSERT INTO agendas (profesional_id, dia_semana, hora_inicio, hora_fin, duracion_minutos, activo)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['profesional_id'],
            $data['dia_semana'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $data['duracion_minutos'] ?? 30,
            $data['activo'] ?? 1
        ]);
        return self::db()->lastInsertId();
    }

    public static function update($id, $data) {
        $stmt = self::db()->prepare("
            UPDATE agendas 
            SET dia_semana = ?, hora_inicio = ?, hora_fin = ?, duracion_minutos = ?, activo = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['dia_semana'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $data['duracion_minutos'] ?? 30,
            $data['activo'] ?? 1,
            $id
        ]);
    }

    public static function delete($id) {
        $stmt = self::db()->prepare("DELETE FROM agendas WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public static function existeDuplicado($profesional_id, $dia_semana, $hora_inicio, $hora_fin, $excluir_id = null) {
        $sql = "SELECT COUNT(*) FROM agendas 
                WHERE profesional_id = ? 
                AND dia_semana = ? 
                AND hora_inicio = ? 
                AND hora_fin = ? 
                AND activo = 1";
        
        $params = [$profesional_id, $dia_semana, $hora_inicio, $hora_fin];
        
        if ($excluir_id) {
            $sql .= " AND id != ?";
            $params[] = $excluir_id;
        }
        
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }
    public static function existeSuperposicion($profesional_id, $dia_semana, $hora_inicio, $hora_fin, $excluir_id = null) {
        $sql = "SELECT COUNT(*) FROM agendas 
                WHERE profesional_id = ? 
                AND dia_semana = ? 
                AND activo = 1
                AND hora_inicio < ? 
                AND hora_fin > ?";
        
        $params = [$profesional_id, $dia_semana, $hora_fin, $hora_inicio];
        
        if ($excluir_id) {
            $sql .= " AND id != ?";
            $params[] = $excluir_id;
        }
        
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }
}
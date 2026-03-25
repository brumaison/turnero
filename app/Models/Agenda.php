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

    public static function estaDisponible($profesional_id, $fecha_hora, $duracion_minutos = 30) {
        // Obtener día de la semana (1=Lunes, 7=Domingo)
        $datetime = new \DateTime($fecha_hora);
        $dia_semana = (int)$datetime->format('N'); // 1-7
        $hora = $datetime->format('H:i:s');
        $hora_fin_turno = date('H:i:s', strtotime($hora) + ($duracion_minutos * 60));
        
        // Verificar si hay agenda configurada para ese día
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
            return false; // No hay agenda configurada para ese horario
        }
        
        // Verificar que no haya turnos superpuestos
        $stmt = self::db()->prepare("
            SELECT COUNT(*) FROM turnos 
            WHERE profesional_id = ? 
            AND fecha_hora = ?
            AND estado_id NOT IN (3, 4) -- No contar cancelados o ausentes
        ");
        $stmt->execute([$profesional_id, $fecha_hora]);
        $turnos_existentes = $stmt->fetchColumn();
        
        return $turnos_existentes == 0;
    }

    public static function getHorariosDisponibles($profesional_id, $fecha) {
        $datetime = new \DateTime($fecha);
        $dia_semana = (int)$datetime->format('N');
        
        // Obtener agenda del día
        $stmt = self::db()->prepare("
            SELECT * FROM agendas 
            WHERE profesional_id = ? 
            AND dia_semana = ? 
            AND activo = 1
        ");
        $stmt->execute([$profesional_id, $dia_semana]);
        $agendas = $stmt->fetchAll();
        
        if (empty($agendas)) {
            return []; // No hay agenda ese día
        }
        
        // Obtener turnos ya ocupados
        $stmt = self::db()->prepare("
            SELECT fecha_hora FROM turnos 
            WHERE profesional_id = ? 
            AND DATE(fecha_hora) = ?
            AND estado_id NOT IN (3, 4)
        ");
        $stmt->execute([$profesional_id, $fecha]);
        $turnos_ocupados = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        
        // Generar horarios disponibles
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
}
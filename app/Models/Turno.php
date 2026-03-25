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

    public static function getRango($fecha_inicio, $fecha_fin, $profesional_id = null) {
        if ($profesional_id) {
            $stmt = self::db()->prepare("
                SELECT t.*, p.nombre, p.apellido, p.dni, pr.nombre as profesional
                FROM turnos t
                JOIN pacientes p ON t.paciente_id = p.id
                JOIN profesionales pr ON t.profesional_id = pr.id
                WHERE DATE(t.fecha_hora) BETWEEN ? AND ?
                AND t.profesional_id = ?
                ORDER BY t.fecha_hora ASC
            ");
            $stmt->execute([$fecha_inicio, $fecha_fin, $profesional_id]);
        } else {
            $stmt = self::db()->prepare("
                SELECT t.*, p.nombre, p.apellido, p.dni, pr.nombre as profesional
                FROM turnos t
                JOIN pacientes p ON t.paciente_id = p.id
                JOIN profesionales pr ON t.profesional_id = pr.id
                WHERE DATE(t.fecha_hora) BETWEEN ? AND ?
                ORDER BY t.fecha_hora ASC
            ");
            $stmt->execute([$fecha_inicio, $fecha_fin]);
        }
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $stmt = self::db()->prepare("
            INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, observaciones, estado_id, duracion_minutos)
            VALUES (:paciente_id, :profesional_id, :consultorio_id, :fecha_hora, :observaciones, :estado_id, :duracion_minutos)
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
                duracion_minutos = :duracion_minutos
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public static function getConsultorios() {
        $stmt = self::db()->query("SELECT id, nombre FROM consultorios ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public static function existeSuperposicion($profesional_id, $fecha_hora, $duracion_minutos = 30) {
        // Calcular hora fin del turno
        $datetime = new \DateTime($fecha_hora);
        $hora_fin = date('Y-m-d H:i:s', strtotime($fecha_hora) + ($duracion_minutos * 60));
        
        $stmt = self::db()->prepare("
            SELECT COUNT(*) FROM turnos 
            WHERE profesional_id = :prof 
            AND fecha_hora = :fecha
            AND estado_id NOT IN (3, 4)
        ");
        $stmt->execute(['prof' => $profesional_id, 'fecha' => $fecha_hora]);
        return $stmt->fetchColumn() > 0;
    }
}
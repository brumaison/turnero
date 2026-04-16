<?php
namespace App\Models;

use App\Core\Model;

class Consulta extends Model {
    protected static $table = 'consultas';

    // Obtener consulta por turno
    public static function getByTurnoId($turno_id) {
        $stmt = self::db()->prepare("SELECT * FROM consultas WHERE turno_id = ?");
        $stmt->execute([$turno_id]);
        return $stmt->fetch() ?: null;
    }
    public static function findById($id) {
        $stmt = self::db()->prepare("SELECT * FROM consultas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    // Historial clínico: todas las consultas de un paciente
    public static function getByPacienteId($paciente_id) {
        $stmt = self::db()->prepare("
            SELECT c.*, t.fecha_hora, pr.nombre as profesional
            FROM consultas c
            JOIN turnos t ON c.turno_id = t.id
            JOIN profesionales pr ON c.profesional_id = pr.id
            WHERE c.paciente_id = ?
            ORDER BY t.fecha_hora DESC
        ");
        $stmt->execute([$paciente_id]);
        return $stmt->fetchAll();
    }

    // Consultas de un médico (para su dashboard)
    public static function getByProfesionalId($profesional_id, $limit = 10) {
        $stmt = self::db()->prepare("
            SELECT c.*, t.fecha_hora, p.apellido, p.nombre as paciente_nombre
            FROM consultas c
            JOIN turnos t ON c.turno_id = t.id
            JOIN pacientes p ON c.paciente_id = p.id
            WHERE c.profesional_id = ?
            ORDER BY t.fecha_hora DESC
            LIMIT ?
        ");
        $stmt->execute([$profesional_id, $limit]);
        return $stmt->fetchAll();
    }

    // Crear consulta (al marcar turno como realizado)
    public static function create($data) {
        $stmt = self::db()->prepare("
            INSERT INTO consultas (turno_id, paciente_id, profesional_id, diagnostico, notas)
            VALUES (:turno_id, :paciente_id, :profesional_id, :diagnostico, :notas)
        ");
        return $stmt->execute($data);
    }

    // Actualizar notas/diagnóstico
    public static function update($id, $data) {
        $stmt = self::db()->prepare("
            UPDATE consultas 
            SET diagnostico = :diagnostico, notas = :notas
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}
<?php
namespace App\Models;

use App\Core\Model;

class Profesional extends Model {
    protected static $table = 'profesionales';

    public static function todos() {
        $stmt = self::db()->query("
            SELECT p.*, GROUP_CONCAT(e.nombre SEPARATOR ', ') as especialidades
            FROM profesionales p
            LEFT JOIN profesional_especialidad pe ON p.id = pe.profesional_id
            LEFT JOIN especialidades e ON pe.especialidad_id = e.id
            GROUP BY p.id
            ORDER BY p.nombre
        ");
        return $stmt->fetchAll();
    }

    public static function getEspecialidades($profesional_id) {
        $stmt = self::db()->prepare("
            SELECT e.* FROM especialidades e
            INNER JOIN profesional_especialidad pe ON e.id = pe.especialidad_id
            WHERE pe.profesional_id = ?
        ");
        $stmt->execute([$profesional_id]);
        return $stmt->fetchAll();
    }

    public static function getAgenda($profesional_id) {
        $stmt = self::db()->prepare("SELECT * FROM agendas WHERE profesional_id = ? AND activo = 1 ORDER BY dia_semana, hora_inicio");
        $stmt->execute([$profesional_id]);
        return $stmt->fetchAll();
    }

    public static function create($data) {
        $stmt = self::db()->prepare("
            INSERT INTO profesionales (nombre, consultorio_default_id, duracion_default)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $data['nombre'],
            $data['consultorio_default_id'] ?? null,
            $data['duracion_default'] ?? 30
        ]);
        $profesional_id = self::db()->lastInsertId();
        
        // Vincular especialidades si vienen
        if (!empty($data['especialidades'])) {
            foreach ($data['especialidades'] as $esp_id) {
                self::db()->prepare("INSERT INTO profesional_especialidad (profesional_id, especialidad_id) VALUES (?, ?)")
                    ->execute([$profesional_id, $esp_id]);
            }
        }
        
        return $profesional_id;
    }

    public static function update($id, $data) {
        $stmt = self::db()->prepare("
            UPDATE profesionales 
            SET nombre = ?, consultorio_default_id = ?, duracion_default = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['nombre'],
            $data['consultorio_default_id'] ?? null,
            $data['duracion_default'] ?? 30,
            $id
        ]);
        
        // Actualizar especialidades
        if (isset($data['especialidades'])) {
            // Eliminar viejas
            self::db()->prepare("DELETE FROM profesional_especialidad WHERE profesional_id = ?")->execute([$id]);
            // Agregar nuevas
            foreach ($data['especialidades'] as $esp_id) {
                self::db()->prepare("INSERT INTO profesional_especialidad (profesional_id, especialidad_id) VALUES (?, ?)")
                    ->execute([$id, $esp_id]);
            }
        }
        
        return true;
    }

    public static function delete($id) {
        $stmt = self::db()->prepare("DELETE FROM profesionales WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
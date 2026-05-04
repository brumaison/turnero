<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;


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

    public static function createWithOperator($data) {
        $db = Database::getInstance();
        $db->beginTransaction();
        
        try {
            // 1. Crear operador (login)
            $stmt = $db->prepare("
                INSERT INTO operadores (email, password_hash, role_id) 
                VALUES (:email, :password, 3)
            ");
            $stmt->execute([
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
            $operador_id = $db->lastInsertId();
            
            // 2. Crear profesional con user_id vinculado
            $stmt = $db->prepare("
                INSERT INTO profesionales (user_id, nombre, consultorio_default_id, duracion_default)
                VALUES (:user_id, :nombre, :consultorio, :duracion)
            ");
            $stmt->execute([
                'user_id' => $operador_id,
                'nombre' => $data['nombre'],
                'consultorio' => $data['consultorio_default_id'] ?? null,
                'duracion' => $data['duracion_default'] ?? 30
            ]);
            $profesional_id = $db->lastInsertId();
            
            // 3. Vincular especialidades si vienen
            if (!empty($data['especialidades'])) {
                foreach ($data['especialidades'] as $esp_id) {
                    $db->prepare("INSERT INTO profesional_especialidad (profesional_id, especialidad_id) VALUES (?, ?)")
                        ->execute([$profesional_id, $esp_id]);
                }
            }
            
            $db->commit();
            return $profesional_id;
            
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Actualizar profesional + operador (email/password) en transacción
     */
    public static function updateWithOperator($id, $data) {
        $db = Database::getInstance();
        
        // Obtener user_id actual del profesional
        $stmt = $db->prepare("SELECT user_id FROM profesionales WHERE id = ?");
        $stmt->execute([$id]);
        $profesional = $stmt->fetch();
        $user_id = $profesional['user_id'];
        
        $db->beginTransaction();
        
        try {
            // 1. Actualizar profesional (nombre, consultorio, duración)
            $stmt = $db->prepare("
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
            
            // 2. Manejar operador (crear o actualizar)
            if (empty($user_id)) {
                // 🔹 CASO: Profesional sin operador → CREAR uno nuevo
                if (!empty($data['email']) && !empty($data['password'])) {
                    // Crear operador
                    $stmt = $db->prepare("
                        INSERT INTO operadores (email, password_hash, role_id) 
                        VALUES (?, ?, 3)
                    ");
                    $stmt->execute([
                        $data['email'],
                        password_hash($data['password'], PASSWORD_DEFAULT)
                    ]);
                    $user_id = $db->lastInsertId();
                    
                    // Vincular operador al profesional
                    $stmt = $db->prepare("UPDATE profesionales SET user_id = ? WHERE id = ?");
                    $stmt->execute([$user_id, $id]);
                }
                // Si no hay email/password, simplemente no creamos operador
            } else {
                // 🔹 CASO: Profesional YA tiene operador → ACTUALIZAR
                
                // Actualizar email
                if (!empty($data['email'])) {
                    $stmt = $db->prepare("UPDATE operadores SET email = ? WHERE id = ?");
                    $stmt->execute([$data['email'], $user_id]);
                }
                
                // Actualizar password (solo si se proveyó)
                if (!empty($data['password'])) {
                    $stmt = $db->prepare("UPDATE operadores SET password_hash = ? WHERE id = ?");
                    $stmt->execute([
                        password_hash($data['password'], PASSWORD_DEFAULT),
                        $user_id
                    ]);
                }
            }
            
            // 3. Actualizar especialidades
            if (isset($data['especialidades'])) {
                $db->prepare("DELETE FROM profesional_especialidad WHERE profesional_id = ?")->execute([$id]);
                foreach ($data['especialidades'] as $esp_id) {
                    $db->prepare("INSERT INTO profesional_especialidad (profesional_id, especialidad_id) VALUES (?, ?)")
                        ->execute([$id, $esp_id]);
                }
            }
            
            $db->commit();
            return true;
            
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Obtener profesional con email del operador vinculado
     */
    public static function findWithOperator($id) {
        $stmt = self::db()->prepare("
            SELECT p.*, o.email 
            FROM profesionales p
            LEFT JOIN operadores o ON p.user_id = o.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
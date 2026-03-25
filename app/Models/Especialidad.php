<?php
namespace App\Models;

use App\Core\Model;

class Especialidad extends Model {
    protected static $table = 'especialidades';

    public static function all() {
        $stmt = self::db()->query("SELECT * FROM especialidades ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public static function find($id) {
        $stmt = self::db()->prepare("SELECT * FROM especialidades WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($data) {
        $stmt = self::db()->prepare("INSERT INTO especialidades (nombre) VALUES (?)");
        $stmt->execute([$data['nombre']]);
        return self::db()->lastInsertId();
    }

    public static function update($id, $data) {
        $stmt = self::db()->prepare("UPDATE especialidades SET nombre = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'], $id]);
    }

    public static function delete($id) {
        $stmt = self::db()->prepare("DELETE FROM especialidades WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
<?php
namespace App\Core;

class Model {
    protected static $table;

    public static function db() {
        return Database::getInstance();
    }

    public static function all() {
        $stmt = self::db()->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll();
    }

    public static function find($id) {
        $stmt = self::db()->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
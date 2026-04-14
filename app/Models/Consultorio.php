<?php
namespace App\Models;

use App\Core\Model;

class Consultorio extends Model {
    protected static $table = 'consultorios';

    public static function todos() {
        $stmt = self::db()->query("SELECT * FROM consultorios ORDER BY nombre");
        return $stmt->fetchAll();
    }
}
<?php
namespace App\Models;

use App\Core\Model;

class Paciente extends Model {
    protected static $table = 'pacientes';

    public static function buscar($texto) {
        $stmt = self::db()->prepare("
            SELECT id, dni, nombre, apellido, telefono 
            FROM pacientes 
            WHERE nombre LIKE :texto OR apellido LIKE :texto OR dni LIKE :texto
            LIMIT 10
        ");
        $stmt->execute(['texto' => "%{$texto}%"]);
        return $stmt->fetchAll();
    }
    public static function findById($id) {
        $stmt = self::db()->prepare("SELECT * FROM pacientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
    public static function create($data) {
        $stmt = self::db()->prepare("
            INSERT INTO pacientes (dni, apellido, nombre, email, telefono)
            VALUES (:dni, :apellido, :nombre, :email, :telefono)
        ");
        
        // Separar "Apellido, Nombre" si viene junto
        $partes = explode(',', $data['nombre']);
        $apellido = trim($partes[0]);
        $nombre = trim($partes[1] ?? '');
        
        $stmt->execute([
            'dni' => $data['dni'],
            'apellido' => $apellido,
            'nombre' => $nombre,
            'email' => $data['email'] ?? null,
            'telefono' => $data['telefono'] ?? null,
        ]);
        
        return self::db()->lastInsertId();
    }
}
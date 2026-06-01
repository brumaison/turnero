<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Operador extends Model {
    protected static $table = 'operadores';

    public static function todos() {
        $stmt = self::db()->query("
            SELECT o.*, r.nombre as role_nombre, r.slug as role_slug,
                   p.nombre as profesional_nombre
            FROM operadores o
            LEFT JOIN roles r ON o.role_id = r.id
            LEFT JOIN profesionales p ON o.id = p.user_id
            ORDER BY o.email
        ");
        return $stmt->fetchAll();
    }

    public static function getRoles() {
        $stmt = self::db()->query("SELECT * FROM roles ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public static function crear($data) {
        $stmt = self::db()->prepare("
            INSERT INTO operadores (email, password_hash, role_id)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role_id'] ?? null
        ]);
    }

    public static function actualizar($id, $data) {
        $fields = [];
        $params = [];

        if (!empty($data['email'])) {
            $fields[] = 'email = ?';
            $params[] = $data['email'];
        }

        if (!empty($data['password'])) {
            $fields[] = 'password_hash = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (isset($data['role_id'])) {
            $fields[] = 'role_id = ?';
            $params[] = $data['role_id'] ?: null;
        }

        if (empty($fields)) {
            return true;
        }

        $params[] = $id;
        $sql = "UPDATE operadores SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = self::db()->prepare($sql);
        return $stmt->execute($params);
    }

    public static function eliminar($id) {
        $stmt = self::db()->prepare("DELETE FROM operadores WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function emailExiste($email, $excluir_id = null) {
        $sql = "SELECT COUNT(*) FROM operadores WHERE email = ?";
        $params = [$email];

        if ($excluir_id) {
            $sql .= " AND id != ?";
            $params[] = $excluir_id;
        }

        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }
}

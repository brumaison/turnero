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
    

    public static function dniExiste($dni, $excluir_id = null) {
        $sql = "SELECT COUNT(*) FROM pacientes WHERE dni = :dni";
        $params = ['dni' => $dni];
        
        if ($excluir_id) {
            $sql .= " AND id != :id";
            $params['id'] = $excluir_id;
        }
        
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }    
    
    public static function create($data) {
        $stmt = self::db()->prepare("
            INSERT INTO pacientes (dni, apellido, nombre, email, telefono)
            VALUES (:dni, :apellido, :nombre, :email, :telefono)
        ");
        
        return $stmt->execute([
            'dni' => $data['dni'],
            'apellido' => $data['apellido'],
            'nombre' => $data['nombre'],
            'email' => $data['email'] ?? null,
            'telefono' => $data['telefono'] ?? null,
        ]);
    }

    // Listar todos (con paginación simple)
    public static function all($limit = 50) {
        $stmt = self::db()->prepare("SELECT * FROM pacientes ORDER BY apellido, nombre LIMIT ?");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Actualizar paciente
    public static function update($id, $data) {
        $stmt = self::db()->prepare("
            UPDATE pacientes 
            SET dni = :dni, apellido = :apellido, nombre = :nombre, email = :email, telefono = :telefono
            WHERE id = :id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Eliminar (soft delete mas adelante)
    public static function destroy($id) {
        $stmt = self::db()->prepare("DELETE FROM pacientes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Para historial: consultas del paciente
    public static function getHistorial($paciente_id) {
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
    
}
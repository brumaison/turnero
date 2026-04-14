<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\View;

class AuthController {
    
    public function showLogin() {
        View::render('admin/auth/login', [], false);
    }

    public function login() {
        csrf_verify();
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            View::render('admin/auth/login', ['error' => 'Completa todos los campos'], false);
            return;
        }

        $db = Database::getInstance();
        
        // 1. Obtener operador con su rol
        $stmt = $db->prepare("
            SELECT o.*, r.slug as role_slug, r.nombre as role_nombre
            FROM operadores o
            LEFT JOIN roles r ON o.role_id = r.id
            WHERE o.email = :email
        ");
        $stmt->execute(['email' => $email]);
        $operador = $stmt->fetch();

        if ($operador && password_verify($password, $operador['password_hash'])) {
            // 2. Sessiones básicas
            $_SESSION['user_id'] = $operador['id'];
            $_SESSION['user_email'] = $operador['email'];
            
            // 3. Rol (ahora desde tabla roles)
            $_SESSION['user_role_id'] = $operador['role_id'];
            $_SESSION['user_role_slug'] = $operador['role_slug'];
            
            // 4. Consultorios (puede ser múltiple, desde pivot)
            $stmt = $db->prepare("
                SELECT consultorio_id FROM operador_consultorios 
                WHERE operador_id = :operador_id
            ");
            $stmt->execute(['operador_id' => $operador['id']]);
            $consultorios = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
            $_SESSION['user_consultorios'] = $consultorios; // Array [1, 2, 3]

            // 5. Si es médico, buscar su profesional_id
            if ($operador['role_slug'] === 'medico') {
                $stmt = $db->prepare("
                    SELECT id FROM profesionales 
                    WHERE user_id = :user_id 
                    LIMIT 1
                ");
                $stmt->execute(['user_id' => $operador['id']]);
                $profesional = $stmt->fetch();
                
                $_SESSION['profesional_id'] = $profesional['id'] ?? null;
            }
            
            redirect('/admin/turnos');
        } else {
            View::render('admin/auth/login', ['error' => 'Email o contraseña incorrectos'], false);
        }
    }

    public function logout() {
        session_destroy();
        redirect('/admin/login');
    }
}
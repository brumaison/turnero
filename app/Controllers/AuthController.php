<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;

class AuthController {
    
    public function showLogin() {
        View::render('auth/login');
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            View::render('auth/login', ['error' => 'Completa todos los campos']);
            return;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM operadores WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $operador = $stmt->fetch();

        if ($operador && password_verify($password, $operador['password_hash'])) {
            $_SESSION['user_id'] = $operador['id'];
            $_SESSION['user_email'] = $operador['email'];
            $_SESSION['user_rol'] = $operador['rol'];
            $_SESSION['user_consultorio_id'] = $operador['consultorio_id'];
            
            redirect('/turnos');
        } else {
            View::render('auth/login', ['error' => 'Email o contraseña incorrectos']);
        }
    }
    public function logout() {
        session_destroy();
        redirect('/login');
    }
}
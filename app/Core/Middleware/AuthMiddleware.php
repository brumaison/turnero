<?php
namespace App\Core\Middleware;

class AuthMiddleware {
    public function handle(): bool {
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
            return false;
        }
        return true;
    }
}
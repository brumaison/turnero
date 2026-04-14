<?php
namespace App\Core\Middleware;

class RoleMiddleware {
    
    /**
     * Verificar si el usuario tiene al menos uno de los roles permitidos
     * @param array $allowedRoles Slugs de roles permitidos (ej: ['admin', 'recepcion'])
     * @return bool
     */
    public function handle(array $allowedRoles = []): bool {
        if (!isset($_SESSION['user_id'])) {
            redirect('/admin/login');
            return false;
        }
        
        $userRole = $_SESSION['user_role_slug'] ?? '';
        
        if (!in_array($userRole, $allowedRoles)) {
            // Flash::error('Acceso denegado: rol no autorizado');
            redirect('/admin/turnos');
            return false;
        }
        
        return true;
    }
}
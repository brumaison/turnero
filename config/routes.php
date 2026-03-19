<?php
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\TurnosController;
// Agregar más controllers acá cuando los uses:
// use App\Controllers\Admin\PacientesController;
// use App\Controllers\Admin\ProfesionalesController;

return function($router) {
    // Públicas
    $router->get('/', function() { redirect('/admin/login'); }, []);
    
    // Admin: Login (público)
    $router->get('/admin/login', [AuthController::class, 'showLogin'], []);
    $router->post('/admin/login', [AuthController::class, 'login'], []);

    $router->get('/admin', function() {
        if (isset($_SESSION['user_id'])) {
            redirect('/admin/turnos');
        }
        redirect('/admin/login');
    }, []);
    
    // Redirección amigable: /login → /admin/login (opcional)
    $router->get('/login', function() {
        header('Location: /admin/login');
        exit;
    }, []);

    // Admin: Rutas protegidas (con middleware 'auth')
    $router->get('/admin/logout', [AuthController::class, 'logout'], ['auth']);
    $router->get('/admin/turnos', [TurnosController::class, 'index'], ['auth']);
    $router->post('/admin/turnos/buscar', [TurnosController::class, 'buscarPaciente'], ['auth']);
    $router->post('/admin/turnos/crear', [TurnosController::class, 'crearYReservar'], ['auth']);
};
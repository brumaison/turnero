<?php
use App\Controllers\AuthController;
use App\Controllers\TurnosController;

return function($router) {
    // Públicas
    $router->get('/', function() { redirect('/login'); }, []);
    $router->get('/login', [AuthController::class, 'showLogin'], []);
    $router->post('/login', [AuthController::class, 'login'], []);

    // Protegidas (con middleware 'auth')
    $router->get('/logout', [AuthController::class, 'logout'], ['auth']);
    $router->get('/turnos', [TurnosController::class, 'index'], ['auth']);
    $router->post('/turnos/buscar', [TurnosController::class, 'buscarPaciente'], ['auth']);
    $router->post('/turnos/crear', [TurnosController::class, 'crearYReservar'], ['auth']);
};
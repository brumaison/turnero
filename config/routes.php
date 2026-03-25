<?php
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\TurnosController;
use App\Controllers\Admin\EspecialidadesController;
use App\Controllers\Admin\ProfesionalesController;
use App\Controllers\Admin\AgendasController;

return function($router) {
    // Públicas
    $router->get('/', function() { redirect('/admin/login'); }, []);
    
    // Admin: Login
    $router->get('/admin/login', [AuthController::class, 'showLogin'], []);
    $router->post('/admin/login', [AuthController::class, 'login'], []);

    $router->get('/admin', function() {
        if (isset($_SESSION['user_id'])) {
            redirect('/admin/turnos');
        }
        redirect('/admin/login');
    }, []);
    
    $router->get('/login', function() {
        header('Location: /admin/login');
        exit;
    }, []);

    // Admin: Protegidas
    $router->get('/admin/logout', [AuthController::class, 'logout'], ['auth']);
    
    // === ESPECIALIDADES ===
    $router->get('/admin/especialidades', [EspecialidadesController::class, 'index'], ['auth']);
    $router->get('/admin/especialidades/create', [EspecialidadesController::class, 'create'], ['auth']);
    $router->post('/admin/especialidades/store', [EspecialidadesController::class, 'store'], ['auth']);
    $router->get('/admin/especialidades/{id}/edit', [EspecialidadesController::class, 'edit'], ['auth']);
    $router->post('/admin/especialidades/{id}/update', [EspecialidadesController::class, 'update'], ['auth']);
    $router->get('/admin/especialidades/{id}/destroy', [EspecialidadesController::class, 'destroy'], ['auth']);
    
    // === PROFESIONALES ===
    $router->get('/admin/profesionales', [ProfesionalesController::class, 'index'], ['auth']);
    $router->get('/admin/profesionales/create', [ProfesionalesController::class, 'create'], ['auth']);
    $router->post('/admin/profesionales/store', [ProfesionalesController::class, 'store'], ['auth']);
    $router->get('/admin/profesionales/{id}/edit', [ProfesionalesController::class, 'edit'], ['auth']);
    $router->post('/admin/profesionales/{id}/update', [ProfesionalesController::class, 'update'], ['auth']);
    $router->get('/admin/profesionales/{id}/destroy', [ProfesionalesController::class, 'destroy'], ['auth']);
    
    // Agenda de un profesional
    $router->get('/admin/profesionales/{id}/agenda', [ProfesionalesController::class, 'agenda'], ['auth']);
    
    // === AGENDAS (CRUD por profesional) ===
    $router->get('/admin/profesionales/{profesional_id}/agenda/create', [AgendasController::class, 'create'], ['auth']);
    $router->post('/admin/profesionales/{profesional_id}/agenda/store', [AgendasController::class, 'store'], ['auth']);
    $router->get('/admin/profesionales/{profesional_id}/agenda/{agenda_id}/edit', [AgendasController::class, 'edit'], ['auth']);
    $router->post('/admin/profesionales/{profesional_id}/agenda/{agenda_id}/update', [AgendasController::class, 'update'], ['auth']);
    $router->get('/admin/profesionales/{profesional_id}/agenda/{agenda_id}/destroy', [AgendasController::class, 'destroy'], ['auth']);
    
    // === TURNOS (REST - inglés) ===
    $router->get('/admin/turnos', [TurnosController::class, 'index'], ['auth']);
    $router->get('/admin/turnos/create', [TurnosController::class, 'create'], ['auth']);
    $router->post('/admin/turnos/store', [TurnosController::class, 'store'], ['auth']);
    $router->get('/admin/turnos/search-patient', [TurnosController::class, 'searchPatient'], ['auth']);
    
    // Turnos: Calendario
    $router->get('/admin/turnos/calendar', [TurnosController::class, 'calendar'], ['auth']);
    $router->get('/admin/turnos/get-events', [TurnosController::class, 'getEvents'], ['auth']);
};
<?php
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\TurnosController;
use App\Controllers\Admin\EspecialidadesController;
use App\Controllers\Admin\ProfesionalesController;
use App\Controllers\Admin\AgendasController;
use App\Controllers\Admin\ConsultasController;

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
    
    // === ESPECIALIDADES (solo admin,recepcion) ===
    $router->get('/admin/especialidades', [EspecialidadesController::class, 'index'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/especialidades/create', [EspecialidadesController::class, 'create'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/especialidades/store', [EspecialidadesController::class, 'store'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/especialidades/{id}/edit', [EspecialidadesController::class, 'edit'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/especialidades/{id}/update', [EspecialidadesController::class, 'update'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/especialidades/{id}/destroy', [EspecialidadesController::class, 'destroy'], ['auth', 'role:admin,recepcion']);
    
    // === PROFESIONALES (solo admin,recepcion) ===
    $router->get('/admin/profesionales', [ProfesionalesController::class, 'index'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/profesionales/create', [ProfesionalesController::class, 'create'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/profesionales/store', [ProfesionalesController::class, 'store'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/profesionales/{id}/edit', [ProfesionalesController::class, 'edit'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/profesionales/{id}/update', [ProfesionalesController::class, 'update'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/profesionales/{id}/destroy', [ProfesionalesController::class, 'destroy'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/profesionales/{id}/agenda', [ProfesionalesController::class, 'agenda'], ['auth', 'role:admin,recepcion']);
    
    // === AGENDAS (solo admin,recepcion) ===
    $router->get('/admin/profesionales/{profesional_id}/agenda/create', [AgendasController::class, 'create'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/profesionales/{profesional_id}/agenda/store', [AgendasController::class, 'store'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/profesionales/{profesional_id}/agenda/{agenda_id}/edit', [AgendasController::class, 'edit'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/profesionales/{profesional_id}/agenda/{agenda_id}/update', [AgendasController::class, 'update'], ['auth', 'role:admin,recepcion']);
    $router->get('/admin/profesionales/{profesional_id}/agenda/{agenda_id}/destroy', [AgendasController::class, 'destroy'], ['auth', 'role:admin,recepcion']);
    
    // === TURNOS (REST - inglés) ===
    $router->get('/admin/turnos', [TurnosController::class, 'index'], ['auth']);
    $router->get('/admin/turnos/create', [TurnosController::class, 'create'], ['auth', 'role:admin,recepcion']);
    $router->post('/admin/turnos/store', [TurnosController::class, 'store'], ['auth', 'role:admin,recepcion']);
    
    // Editar turno
    $router->get('/admin/turnos/{id}/edit', [TurnosController::class, 'edit'], ['auth']);
    $router->post('/admin/turnos/{id}/update', [TurnosController::class, 'update'], ['auth']);
    
    $router->get('/admin/turnos/search-patient', [TurnosController::class, 'searchPatient'], ['auth']);
    
    // Turnos: Calendario
    $router->get('/admin/turnos/calendar', [TurnosController::class, 'calendar'], ['auth']);
    $router->get('/admin/turnos/get-events', [TurnosController::class, 'getEvents'], ['auth']);
    $router->get('/admin/turnos/available-slots', [TurnosController::class, 'availableSlots'], ['auth']);

    // === CONSULTAS (solo médicos) ===
    $router->get('/admin/consultas/{id}/atender', [ConsultasController::class, 'atender'], ['auth', 'role:medico']);
    $router->post('/admin/consultas/store', [ConsultasController::class, 'store'], ['auth', 'role:medico']);
    $router->get('/admin/consultas/{id}/ver', [ConsultasController::class, 'ver'], ['auth', 'role:medico']);
};
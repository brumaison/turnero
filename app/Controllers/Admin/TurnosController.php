<?php
namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Turno;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Agenda;

class TurnosController {
    
    // GET /admin/turnos → Lista con filtros
    public function index() {
        $fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-d');
        $fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');
        $profesional_id = $_GET['profesional_id'] ?? null;
        $estado_id = $_GET['estado_id'] ?? null;
        
        $turnos = Turno::getRango($fecha_inicio, $fecha_fin, $profesional_id);
        
        // Filtrar por estado en PHP (simple) o agregar en Model
        if ($estado_id) {
            $turnos = array_filter($turnos, fn($t) => $t['estado_id'] == $estado_id);
        }
        
        $profesionales = Profesional::todos();
        
        View::render('admin/turnos/index', [
            'turnos' => $turnos,
            'profesionales' => $profesionales,
            'filtros' => ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin, 'profesional_id' => $profesional_id, 'estado_id' => $estado_id],
            'pageTitle' => 'Gestión de Turnos',
            'activePage' => 'turnos'
        ]);
    }

    // GET /admin/turnos/create → Muestra el formulario
    public function create() {
        $profesionales = Profesional::todos();
        $consultorios = Turno::getConsultorios();
        
        // Si viene fecha del calendario, pre-cargar
        $fecha_seleccionada = $_GET['fecha'] ?? null;
        
        View::render('admin/turnos/create', [
            'profesionales' => $profesionales,
            'consultorios' => $consultorios,
            'fecha_seleccionada' => $fecha_seleccionada,
            'pageTitle' => 'Nuevo Turno',
            'activePage' => 'turnos'
        ]);
    }

    // POST /admin/turnos/store → Guarda y redirige
    public function store() {
        // Validación básica
        if (empty($_POST['fecha_hora']) || strtotime($_POST['fecha_hora']) < time()) {
            $_SESSION['error'] = 'La fecha debe ser futura';
            redirect('/admin/turnos/create');
        }
        
        // Validar contra AGENDA (nuevo)
        $duracion = $_POST['duracion_minutos'] ?? 30;
        if (!Agenda::estaDisponible($_POST['profesional_id'], $_POST['fecha_hora'], $duracion)) {
            $_SESSION['error'] = 'Horario no disponible en la agenda del profesional';
            redirect('/admin/turnos/create');
        }
        
        // Validar superposición (doble check)
        if (Turno::existeSuperposicion($_POST['profesional_id'], $_POST['fecha_hora'], $duracion)) {
            $_SESSION['error'] = 'Ese horario ya está ocupado';
            redirect('/admin/turnos/create');
        }
        
        // Resolver paciente_id (existente o nuevo)
        $paciente_id = $_POST['paciente_id'] ?? null;
        
        if (empty($paciente_id) && !empty($_POST['nuevo_paciente_dni'])) {
            $paciente_id = Paciente::create([
                'dni' => $_POST['nuevo_paciente_dni'],
                'nombre' => $_POST['nuevo_paciente_nombre'],
                'email' => $_POST['nuevo_paciente_email'] ?? null,
                'telefono' => $_POST['nuevo_paciente_telefono'] ?? null,
            ]);
        }
        
        if (empty($paciente_id)) {
            $_SESSION['error'] = 'Debe seleccionar o crear un paciente';
            redirect('/admin/turnos/create');
        }
        
        $data = [
            'paciente_id' => $paciente_id,
            'profesional_id' => $_POST['profesional_id'] ?? null,
            'consultorio_id' => $_POST['consultorio_id'] ?? null,
            'fecha_hora' => $_POST['fecha_hora'] ?? null,
            'observaciones' => $_POST['observaciones'] ?? '',
            'estado_id' => 1,
            'duracion_minutos' => $duracion,
        ];
        
        if (Turno::create($data)) {
            $_SESSION['success'] = 'Turno creado';
        } else {
            $_SESSION['error'] = 'Error al crear';
        }
        redirect('/admin/turnos');
    }

    // GET /admin/turnos/search-patient → JSON para autocomplete
    public function searchPatient() {
        header('Content-Type: application/json');
        $texto = $_GET['q'] ?? '';
        $pacientes = Paciente::buscar($texto);
        echo json_encode($pacientes);
    }

    // GET /admin/turnos/calendar → Vista calendario
    public function calendar() {
        $profesionales = Profesional::todos();
        View::render('admin/turnos/calendar', [
            'profesionales' => $profesionales,
            'pageTitle' => 'Calendario de Turnos',
            'activePage' => 'turnos'
        ]);
    }

    // GET /admin/turnos/get-events → JSON para FullCalendar
    public function getEvents() {
        header('Content-Type: application/json');
        
        $start = $_GET['start'] ?? date('Y-m-d');
        $end = $_GET['end'] ?? date('Y-m-d', strtotime('+30 days'));
        $profesional_id = $_GET['profesional_id'] ?? null;
        
        $turnos = Turno::getRango($start, $end, $profesional_id);
        
        $events = [];
        foreach ($turnos as $turno) {
            $events[] = [
                'id' => $turno['id'],
                'title' => ($turno['apellido'] ?? '') . ', ' . ($turno['nombre'] ?? '') . ' - ' . ($turno['profesional'] ?? ''),
                'start' => $turno['fecha_hora'],
                'backgroundColor' => $this->getColorByEstado($turno['estado_id']),
                'extendedProps' => [
                    'paciente' => $turno['apellido'] . ', ' . $turno['nombre'],
                    'profesional' => $turno['profesional'],
                    'consultorio' => $turno['consultorio_id'] ?? '',
                    'estado' => $turno['estado_id']
                ]
            ];
        }
        
        echo json_encode($events);
    }

    private function getColorByEstado($estado_id) {
        $colores = [
            1 => '#ffc107', // Pendiente - Amarillo
            2 => '#28a745', // Confirmado - Verde
            3 => '#dc3545', // Cancelado - Rojo
            4 => '#6c757d', // Ausente - Gris
            5 => '#17a2b8'  // Realizado - Azul
        ];
        return $colores[$estado_id] ?? '#ffc107';
    }
}
<?php
namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Flash;
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
        csrf_verify();
        if (empty($_POST['fecha_hora']) || strtotime($_POST['fecha_hora']) < time()) {
            Flash::error('La fecha debe ser futura');
            redirect('/admin/turnos/create');
        }
        
        $duracion = $_POST['duracion_minutos'] ?? 30;
        
        // Validar agenda: warning si no hay configuración, error si está ocupada
        $tiene_agenda = Agenda::getByProfesional($_POST['profesional_id']);
        $dia_semana = date('N', strtotime($_POST['fecha_hora']));

        $agenda_dia = array_filter($tiene_agenda, fn($a) => $a['dia_semana'] == $dia_semana && $a['activo']);

        if (empty($agenda_dia)) {
            Flash::warning('El profesional no tiene agenda configurada para ese día. ¿Continuar igual?');
        } elseif (!Agenda::estaDisponible($_POST['profesional_id'], $_POST['fecha_hora'], $duracion)) {
            Flash::error('Horario no disponible en la agenda del profesional');
            redirect('/admin/turnos/create');
        }
        
        if (Turno::existeSuperposicion($_POST['profesional_id'], $_POST['fecha_hora'], $duracion)) {
            Flash::error('Ese horario ya está ocupado');
            redirect('/admin/turnos/create');
        }
        
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
            Flash::error('Debe seleccionar o crear un paciente');
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
            Flash::success('Turno creado');
        } else {
            Flash::error('Error al crear');
        }
        redirect('/admin/turnos');
    }

    // 🔴 NUEVO: GET /admin/turnos/{id}/edit
    public function edit($id) {
        $turno = Turno::findById($id);
        if (!$turno) { 
            Flash::error('Turno no encontrado');
            redirect('/admin/turnos'); 
            return; 
        }
        
        $paciente = Paciente::findById($turno['paciente_id']);
        
        View::render('admin/turnos/edit', [
            'turno' => $turno,
            'paciente' => $paciente,
            'profesionales' => Profesional::todos(),
            'consultorios' => Turno::getConsultorios(),
            'pageTitle' => 'Editar Turno',
            'activePage' => 'turnos',
            'activeSubPage' => 'edit'
        ]);
    }

    // 🔴 NUEVO: POST /admin/turnos/{id}/update
    public function update($id) {
        csrf_verify();
        $duracion = $_POST['duracion_minutos'] ?? 30;
        
        // Validar agenda si cambió horario/profesional
        if (!Agenda::estaDisponible($_POST['profesional_id'], $_POST['fecha_hora'], $duracion, $id)) {
            Flash::error('Horario no disponible en la agenda');
            redirect("/admin/turnos/{$id}/edit");
            return;
        }
        
        $data = [
            'paciente_id' => $_POST['paciente_id'] ?? null,
            'profesional_id' => $_POST['profesional_id'] ?? null,
            'consultorio_id' => $_POST['consultorio_id'] ?? null,
            'fecha_hora' => $_POST['fecha_hora'] ?? null,
            'observaciones' => $_POST['observaciones'] ?? '',
            'estado_id' => $_POST['estado_id'] ?? 1,
            'duracion_minutos' => $duracion,
        ];
        
        if (Turno::update($id, $data)) {
            Flash::success('Turno actualizado');
        } else {
            Flash::error('Error al actualizar');
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
                'start' => date('c', strtotime($turno['fecha_hora'])), // 🔴 Fix timezone: formato ISO 8601
                'backgroundColor' => $this->getColorByEstado($turno['estado_id']),
                'extendedProps' => [
                    'paciente' => $turno['apellido'] . ', ' . $turno['nombre'],
                    'profesional' => $turno['profesional'],
                    'consultorio' => $turno['consultorio_nombre'] ?? 'Sin consultorio', // 🔴 Nombre para popover
                    'estado' => $turno['estado_id']
                ]
            ];
        }
        
        echo json_encode($events);
    }
    // GET /admin/turnos/available-slots → JSON con días y horarios disponibles
    public function availableSlots() {
        header('Content-Type: application/json');
        
        $profesional_id = $_GET['profesional_id'] ?? null;
        $fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-d');
        $dias_a_mostrar = 15;
        
        if (!$profesional_id) {
            echo json_encode(['error' => 'Falta profesional_id']);
            return;
        }
        
        $resultado = [];
        
        for ($i = 0; $i < $dias_a_mostrar; $i++) {
            $fecha = date('Y-m-d', strtotime($fecha_desde . " +$i days"));
            $horarios = Agenda::getHorariosDisponibles($profesional_id, $fecha);
            
            if (!empty($horarios)) {
                $resultado[] = [
                    'fecha' => $fecha,
                    'fecha_label' => date('l d/m', strtotime($fecha)),
                    'horarios' => $horarios
                ];
            }
        }
        
        echo json_encode($resultado);
    }

    private function getColorByEstado($estado_id) {
        $colores = [
            1 => '#ffc107', 2 => '#28a745', 3 => '#dc3545', 4 => '#6c757d', 5 => '#17a2b8'
        ];
        return $colores[$estado_id] ?? '#ffc107';
    }
}
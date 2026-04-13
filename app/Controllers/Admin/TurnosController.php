<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\View;
use App\Core\Flash;
use App\Models\Turno;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Agenda;
use Carbon\Carbon;

class TurnosController extends Controller {

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

    public function store() {
        if (!csrf_verify()) {
            Flash::error('Token de seguridad inválido');
            redirect('/admin/turnos/create');
            return;
        }
        
        if (empty($_POST['fecha_hora']) || strtotime($_POST['fecha_hora']) < time()) {
            Flash::error('La fecha debe ser futura');
            redirect('/admin/turnos/create');
            return;
        }

        $profesional_id = (int)$_POST['profesional_id'];
        $fecha_hora = $_POST['fecha_hora'];
        $duracion = (int)($_POST['duracion_minutos'] ?? 30);
        $es_extraordinario = isset($_POST['extraordinario']) && $_POST['extraordinario'] == '1';
        $confirmacion_extra = isset($_POST['extraordinario_check']) && $_POST['extraordinario_check'] == '1';

        if (!$es_extraordinario) {
            $dia_semana = (int)date('N', strtotime($fecha_hora));
            $agenda_config = Agenda::getByProfesionalYDia($profesional_id, $dia_semana);
            
            if (!$agenda_config) {
                Flash::error('No hay agenda configurada para ese día. Usá "Turno Extraordinario" si es necesario.');
                redirect('/admin/turnos/create');
                return;
            }

            $hora_turno = date('H:i:s', strtotime($fecha_hora));
            $hora_fin_turno = date('H:i:s', strtotime($fecha_hora . " +$duracion minutes"));

            if ($hora_turno < $agenda_config['hora_inicio'] || $hora_fin_turno > $agenda_config['hora_fin']) {
                Flash::error('Horario fuera de agenda. Usá "Turno Extraordinario" si es necesario.');
                redirect('/admin/turnos/create');
                return;
            }
        } else {
            if (!$confirmacion_extra) {
                Flash::error('Debés confirmar el turno extraordinario');
                redirect('/admin/turnos/create');
                return;
            }
            Flash::warning('Turno extraordinario creado');
        }

        if (Turno::existeSuperposicion($profesional_id, $fecha_hora, $duracion)) {
            if (!$es_extraordinario) {
                Flash::error('Ese horario ya está ocupado');
                redirect('/admin/turnos/create');
                return;
            }
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
            return;
        }

        $data = [
            'paciente_id' => $paciente_id,
            'profesional_id' => $profesional_id,
            'consultorio_id' => $_POST['consultorio_id'] ?? null,
            'fecha_hora' => $fecha_hora,
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

    public function update($id) {
        if (!csrf_verify()) {
            Flash::error('Token de seguridad inválido');
            redirect("/admin/turnos/{$id}/edit");
            return;
        }
        
        $duracion = $_POST['duracion_minutos'] ?? 30;

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

    public function searchPatient() {
        header('Content-Type: application/json');
        $texto = $_GET['q'] ?? '';
        $pacientes = Paciente::buscar($texto);
        echo json_encode($pacientes);
    }

    public function calendar() {
        $profesionales = Profesional::todos();
        View::render('admin/turnos/calendar', [
            'profesionales' => $profesionales,
            'pageTitle' => 'Calendario de Turnos',
            'activePage' => 'turnos'
        ]);
    }

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
                'start' => date('c', strtotime($turno['fecha_hora'])),
                'backgroundColor' => $this->getColorByEstado($turno['estado_id']),
                'extendedProps' => [
                    'paciente' => $turno['apellido'] . ', ' . $turno['nombre'],
                    'profesional' => $turno['profesional'],
                    'consultorio' => $turno['consultorio_nombre'] ?? 'Sin consultorio',
                    'estado' => $turno['estado_id']
                ]
            ];
        }

        echo json_encode($events);
    }

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
                    'fecha_label' => carbon_date($fecha)->translatedFormat('l d/m'),
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
<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\View;
use App\Core\Flash;
use App\Models\Turno;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Agenda;
use App\Models\Especialidad;

class TurnosController extends Controller {

    // ─────────────────────────────────────────────────────────────
    // LISTADO + FILTROS
    // ─────────────────────────────────────────────────────────────
    
    public function index() {
        $fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-d');
        $fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');
        $profesional_id = $_GET['profesional_id'] ?? null;
        $estado_id = $_GET['estado_id'] ?? null;

        if ($this->esMedico()) {
            $profesional_id = $_SESSION['profesional_id'] ?? null;
        }

        $turnos = Turno::getRango($fecha_inicio, $fecha_fin, $profesional_id);

        if ($estado_id) {
            $turnos = array_filter($turnos, fn($t) => $t['estado_id'] == $estado_id);
        }

        $profesionales = Profesional::todos();

        View::render('admin/turnos/index', [
            'turnos' => $turnos,
            'profesionales' => $profesionales,
            'estados' => Turno::getEstadosConColor(),
            'filtros' => compact('fecha_inicio', 'fecha_fin', 'profesional_id', 'estado_id'),
            'pageTitle' => 'Gestión de Turnos',
            'activePage' => 'turnos'
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // CREAR TURNO: VISTA
    // ─────────────────────────────────────────────────────────────
    
    public function create() {
        $profesionales = Profesional::todos();
        $especialidades = Especialidad::all();
        $consultorios = Turno::getConsultorios();
        $fecha_seleccionada = $_GET['fecha'] ?? null;
        $profesional_id = $this->esMedico() ? ($_SESSION['profesional_id'] ?? null) : null;

        View::render('admin/turnos/create', [
            'profesionales' => $profesionales,
            'especialidades' => $especialidades,
            'profesional_id' => $profesional_id,
            'consultorios' => $consultorios,
            'fecha_seleccionada' => $fecha_seleccionada,
            'pageTitle' => 'Nuevo Turno',
            'activePage' => 'turnos'
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // CREAR TURNO: PROCESAR (store)
    // ─────────────────────────────────────────────────────────────
    
    public function store() {
        csrf_verify();

        // 🔹 1. Datos base + seguridad por rol
        $profesional_id = $this->esMedico() 
            ? $_SESSION['profesional_id'] 
            : (int)$_POST['profesional_id'];
        
        $fecha_hora = $_POST['fecha_hora'] ?? null;
        
        if (empty($fecha_hora) || strtotime($fecha_hora) < time()) {
            Flash::error('La fecha debe ser futura');
            redirect('/admin/turnos/create');
            return;
        }

        $duracion = (int)($_POST['duracion_minutos'] ?? 30);
        $es_sobreturno = isset($_POST['sobreturno']) && $_POST['sobreturno'] == '1';
        $confirmacion_sobreturno = isset($_POST['sobreturno_check']) && $_POST['sobreturno_check'] == '1';

        // 🔹 2. Validaciones ESPECÍFICAS por tipo de turno
        if (!$es_sobreturno) {
            if (!$this->validarAgenda($profesional_id, $fecha_hora, $duracion)) {
                return;
            }
            if (Turno::existeSuperposicion($profesional_id, $fecha_hora, $duracion)) {
                Flash::error('Ese horario ya está ocupado');
                redirect('/admin/turnos/create');
                return;
            }
        } else {
            if (!$confirmacion_sobreturno) {
                Flash::error('Debés confirmar el sobreturno');
                redirect('/admin/turnos/create');
                return;
            }
        }

        // 🔹 3. Sanitizar consultorio_id (Fase 1)
        $consultorio_id = $this->sanitizarConsultorioId(
            $_POST['consultorio_id'] ?? null, 
            $profesional_id
        );

        // 🔹 4. Validar/resolver paciente
        $paciente_id = $this->resolverPacienteId();
        if (!$paciente_id) {
            Flash::error('Debe seleccionar o crear un paciente');
            $redirect = $es_sobreturno ? '/admin/turnos/create?mode=sobreturno' : '/admin/turnos/create';
            redirect($redirect);
            return;
        }

        // 🔹 5. Mensajes flash (después de validar todo)
        if ($es_sobreturno) {
            Flash::warning('Sobreturno creado');
        }

        // 🔹 6. Crear turno
        $data = [
            'paciente_id' => $paciente_id,
            'profesional_id' => $profesional_id,
            'consultorio_id' => $consultorio_id,
            'fecha_hora' => $fecha_hora,
            'observaciones' => $_POST['observaciones'] ?? '',
            'estado_id' => 1,
            'duracion_minutos' => $duracion,
            'sobreturno' => $es_sobreturno ? 1 : 0,
        ];

        if (Turno::create($data)) {
            if (!$es_sobreturno) {
                Flash::success('Turno creado');
            }
        } else {
            Flash::error('Error al crear');
        }
        
        redirect('/admin/turnos');
    }

    // ─────────────────────────────────────────────────────────────
    // EDITAR TURNO: VISTA
    // ─────────────────────────────────────────────────────────────
    
    public function edit($id) {
        $turno = Turno::findById($id);
        
        if (!$turno || ($this->esMedico() && $turno['profesional_id'] != $_SESSION['profesional_id'])) {
            Flash::error($turno ? 'No tenés permiso para editar este turno' : 'Turno no encontrado');
            redirect('/admin/turnos');
            return;
        }

        $paciente = Paciente::findById($turno['paciente_id']);

        View::render('admin/turnos/edit', [
            'turno' => $turno,
            'paciente' => $paciente,
            'profesionales' => Profesional::todos(),
            'consultorios' => Turno::getConsultorios(),
            'estados' => Turno::getEstadosConColor(),
            'pageTitle' => 'Editar Turno',
            'activePage' => 'turnos',
            'activeSubPage' => 'edit'
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // EDITAR TURNO: PROCESAR (update) - CON FIXES APLICADOS
    // ─────────────────────────────────────────────────────────────
    
    public function update($id) {
        csrf_verify();

        $turno = Turno::findById($id);
        
        if (!$turno || ($this->esMedico() && $turno['profesional_id'] != $_SESSION['profesional_id'])) {
            Flash::error($turno ? 'No tenés permiso para actualizar este turno' : 'Turno no encontrado');
            redirect('/admin/turnos');
            return;
        }

        // Forzar profesional_id si es médico (seguridad)
        if ($this->esMedico()) {
            $_POST['profesional_id'] = $_SESSION['profesional_id'];
        }

        $profesional_id = (int)$_POST['profesional_id'];
        $fecha_hora = $_POST['fecha_hora'] ?? null;
        $duracion = (int)($_POST['duracion_minutos'] ?? 30);

        // 🔹 FIX 1: Solo validar agenda si cambió fecha/hora O profesional
        $turno_original = Turno::findById($id);
        
        // Normalizar fechas para comparar (sin segundos)
        $fecha_original = date('Y-m-d H:i', strtotime($turno_original['fecha_hora']));
        $fecha_nueva = date('Y-m-d H:i', strtotime($_POST['fecha_hora']));
        
        $fecha_cambio = $fecha_nueva !== $fecha_original;
        $profesional_cambio = (int)$_POST['profesional_id'] !== (int)$turno_original['profesional_id'];

        if ($fecha_cambio || $profesional_cambio) {
            if (!Agenda::estaDisponible($profesional_id, $fecha_hora, $duracion, $id)) {
                Flash::error('Horario no disponible en la agenda');
                redirect("/admin/turnos/{$id}/edit");
                return;
            }
        }

        // 🔹 Sanitizar consultorio_id (Fase 1)
        $consultorio_id = $this->sanitizarConsultorioId(
            $_POST['consultorio_id'] ?? null, 
            $profesional_id
        );

        // 🔹 FIX 2: Agregar sobreturno al array de datos
        $data = [
            'paciente_id' => $_POST['paciente_id'] ?? null,
            'profesional_id' => $profesional_id,
            'consultorio_id' => $consultorio_id,
            'fecha_hora' => $fecha_hora,
            'observaciones' => $_POST['observaciones'] ?? '',
            'estado_id' => $_POST['estado_id'] ?? 1,
            'duracion_minutos' => $duracion,
            'sobreturno' => $_POST['sobreturno'] ?? $turno_original['sobreturno'],
        ];

        if (Turno::update($id, $data)) {
            Flash::success('Turno actualizado');
        } else {
            Flash::error('Error al actualizar');
        }
        
        redirect('/admin/turnos');
    }

    // ─────────────────────────────────────────────────────────────
    // API / AJAX
    // ─────────────────────────────────────────────────────────────
    
    public function searchPatient() {
        header('Content-Type: application/json');
        $texto = $_GET['q'] ?? '';
        $pacientes = Paciente::buscar($texto);
        echo json_encode($pacientes);
    }

    public function calendar() {
        $profesionales = $this->esMedico() ? null : Profesional::todos();
        
        View::render('admin/turnos/calendar', [
            'profesionales' => $profesionales,
            'estados' => Turno::getEstadosConColor(),
            'pageTitle' => 'Calendario de Turnos',
            'activePage' => 'turnos'
        ]);
    }

    public function getEvents() {
        header('Content-Type: application/json');

        $start = $_GET['start'] ?? date('Y-m-d');
        $end = $_GET['end'] ?? date('Y-m-d', strtotime('+30 days'));
        $profesional_id = $this->esMedico() 
            ? $_SESSION['profesional_id'] ?? null 
            : $_GET['profesional_id'] ?? null;

        $turnos = Turno::getRango($start, $end, $profesional_id);
        $estados = Turno::getEstadosConColor();
        
        // Crear mapa de colores por estado_id
        $colores_por_estado = [];
        foreach ($estados as $e) {
            $colores_por_estado[$e['id']] = $e['color'];
        }

        $events = array_map(function($turno) use ($colores_por_estado) {
            return [
                'id' => $turno['id'],
                'title' => trim("{$turno['apellido']}, {$turno['nombre']} - {$turno['profesional']}"),
                'start' => date('c', strtotime($turno['fecha_hora'])),
                'backgroundColor' => $colores_por_estado[$turno['estado_id']] ?? '#17a2b8',
                'extendedProps' => [
                    'paciente' => "{$turno['apellido']}, {$turno['nombre']}",
                    'paciente_id' => $turno['paciente_id'],
                    'profesional' => $turno['profesional'],
                    'consultorio' => $turno['consultorio_nombre'] ?? 'Sin consultorio',
                    'estado' => $turno['estado_id'],
                    'observaciones' => $turno['observaciones'] ?? '',
                    'fecha_hora_formatted' => date('d/m/Y H:i', strtotime($turno['fecha_hora']))
                ]
            ];
        }, $turnos);

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

    // 🔹 NUEVO: Buscar horarios disponibles por especialidad
    public function availableSlotsBySpecialty() {
        header('Content-Type: application/json');

        $especialidad_id = $_GET['especialidad_id'] ?? null;
        $fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-d');

        if (!$especialidad_id) {
            echo json_encode(['error' => 'Falta especialidad_id']);
            return;
        }

        $horarios = Turno::getHorariosPorEspecialidad($especialidad_id, $fecha_desde);
        
        if (empty($horarios)) {
            echo json_encode(['error' => 'No hay horarios disponibles']);
            return;
        }

        echo json_encode($horarios);
    }

    // ─────────────────────────────────────────────────────────────
    // HELPERS PRIVADOS
    // ─────────────────────────────────────────────────────────────
    
    private function esMedico(): bool {
        return ($_SESSION['user_role_slug'] ?? '') === 'medico';
    }

    private function validarAgenda($profesional_id, $fecha_hora, $duracion): bool {
        $dia_semana = (int)date('N', strtotime($fecha_hora));
        $agenda_config = Agenda::getByProfesionalYDia($profesional_id, $dia_semana);
        
        if (!$agenda_config) {
            Flash::error('No hay agenda configurada para ese día. Usá "Sobreturno" si es necesario.');
            redirect('/admin/turnos/create');
            return false;
        }

        $hora_turno = date('H:i:s', strtotime($fecha_hora));
        $hora_fin_turno = date('H:i:s', strtotime($fecha_hora . " +$duracion minutes"));

        if ($hora_turno < $agenda_config['hora_inicio'] || $hora_fin_turno > $agenda_config['hora_fin']) {
            Flash::error('Horario fuera de agenda. Usá "Sobreturno" si es necesario.');
            redirect('/admin/turnos/create');
            return false;
        }
        
        return true;
    }

    private function sanitizarConsultorioId($consultorio_id, $profesional_id) {
        if (empty($consultorio_id)) {
            $profesional = Profesional::find($profesional_id);
            return $profesional['consultorio_default_id'] ?? null;
        }
        return $consultorio_id;
    }

    private function resolverPacienteId() {
        $paciente_id = $_POST['paciente_id'] ?? null;

        if (empty($paciente_id) && !empty($_POST['nuevo_paciente_dni'])) {
            $paciente_id = Paciente::create([
                'dni' => $_POST['nuevo_paciente_dni'],
                'nombre' => $_POST['nuevo_paciente_nombre'],
                'email' => $_POST['nuevo_paciente_email'] ?? null,
                'telefono' => $_POST['nuevo_paciente_telefono'] ?? null,
            ]);
        }
        
        return $paciente_id ?: false;
    }

    private function getColorByEstado($estado_id) {
        $colores = [
            1 => '#ffc107', 2 => '#28a745', 3 => '#dc3545', 4 => '#6c757d', 5 => '#17a2b8'
        ];
        return $colores[$estado_id] ?? '#ffc107';
    }
}
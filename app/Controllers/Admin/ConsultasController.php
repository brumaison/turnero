<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\View;
use App\Core\Flash;
use App\Models\Turno;
use App\Models\Consulta;
use App\Models\Paciente;

class ConsultasController extends Controller {

    // Mostrar form para atender turno (solo médico)
    public function atender($turno_id) {
        $turno = Turno::findById($turno_id);
        
        if (!$turno || $turno['profesional_id'] != ($_SESSION['profesional_id'] ?? 0)) {
            redirect('/admin/turnos');
        }
        
        $fecha_turno = date('Y-m-d', strtotime($turno['fecha_hora']));
        $fecha_hoy = date('Y-m-d');

        if ($fecha_turno !== $fecha_hoy) {
            Flash::error('Solo podés atender turnos del día actual');
            redirect('/admin/turnos');
        }

        $consulta = Consulta::getByTurnoId($turno_id);
        if ($consulta) {
            redirect('/admin/consultas/' . $consulta['id'] . '/ver');
        }

        View::render('admin/consultas/atender', [
            'pageTitle' => 'Atender Turno',
            'turno' => $turno
        ]);
    }

    // Guardar consulta    
    public function store() {  // ← Sin parámetros
        $turno_id = $_POST['turno_id'] ?? null;
        $profesional_id = $_SESSION['profesional_id'] ?? null;

        $turno = Turno::findById($turno_id);
        if (!$turno || $turno['profesional_id'] != $profesional_id) {
            redirect('/admin/turnos');
        }

        // Validar día actual
        if (date('Y-m-d', strtotime($turno['fecha_hora'])) !== date('Y-m-d')) {
            redirect('/admin/turnos');
        }

        Consulta::create([
            'turno_id' => $turno_id,
            'paciente_id' => $turno['paciente_id'],
            'profesional_id' => $profesional_id,
            'diagnostico' => $_POST['diagnostico'] ?? null,
            'notas' => $_POST['notas'] ?? null
        ]);

        // Actualizar estado del turno a "Realizado" (5)
        // Solo esto:
        Turno::updateEstado($turno_id, 5);

        redirect('/admin/turnos');
    }

    // Ver consulta
    public function ver($consulta_id) {
    $consulta = Consulta::findById($consulta_id);
    
    if (!$consulta || $consulta['profesional_id'] != ($_SESSION['profesional_id'] ?? 0)) {
        redirect('/admin/turnos');
    }

    // Obtener datos del paciente para mostrar
    $paciente = Paciente::findById($consulta['paciente_id']);

    View::render('admin/consultas/ver', [
        'pageTitle' => 'Detalle de Consulta',
        'consulta' => $consulta,
        'paciente_apellido' => $paciente['apellido'] ?? '',
        'paciente_nombre' => $paciente['nombre'] ?? ''
    ]);
}
}
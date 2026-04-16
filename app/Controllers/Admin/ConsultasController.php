<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\View;
use App\Models\Turno;
use App\Models\Consulta;

class ConsultasController extends Controller {

    // Mostrar form para atender turno (solo médico)
    public function atender($turno_id) {
        $turno = Turno::findById($turno_id);
        
        if (!$turno || $turno['profesional_id'] != ($_SESSION['profesional_id'] ?? 0)) {
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
    public function store(Request $request) {
        $turno_id = $request->input('turno_id');
        $profesional_id = $_SESSION['profesional_id'] ?? null;

        $turno = Turno::findById($turno_id);
        if (!$turno || $turno['profesional_id'] != $profesional_id) {
            redirect('/admin/turnos');
        }

        Consulta::create([
            'turno_id' => $turno_id,
            'paciente_id' => $turno['paciente_id'],
            'profesional_id' => $profesional_id,
            'diagnostico' => $request->input('diagnostico'),
            'notas' => $request->input('notas')
        ]);

        // Actualizar estado del turno a "Realizado" (5)
        $data = $turno;
        $data['estado_id'] = 5;
        Turno::update($turno_id, $data);

        redirect('/admin/turnos');
    }

    // Ver consulta
    public function ver($consulta_id) {
        $consulta = Consulta::findById($consulta_id);
        
        if (!$consulta || $consulta['profesional_id'] != ($_SESSION['profesional_id'] ?? 0)) {
            redirect('/admin/turnos');
        }

        View::render('admin/consultas/ver', [
            'pageTitle' => 'Detalle de Consulta',
            'consulta' => $consulta
        ]);
    }
}
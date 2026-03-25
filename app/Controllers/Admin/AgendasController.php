<?php
namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Agenda;
use App\Models\Profesional;

class AgendasController {
    
    public function create($profesional_id) {
        $profesional = Profesional::find($profesional_id);
        View::render('admin/agendas/create', [
            'profesional' => $profesional,
            'pageTitle' => 'Agregar Horario',
            'activePage' => 'profesionales'
        ]);
    }

    public function store($profesional_id) {
        Agenda::create([
            'profesional_id' => $profesional_id,
            'dia_semana' => $_POST['dia_semana'],
            'hora_inicio' => $_POST['hora_inicio'],
            'hora_fin' => $_POST['hora_fin'],
            'duracion_minutos' => $_POST['duracion_minutos'] ?? 30,
            'activo' => 1
        ]);
        $_SESSION['success'] = 'Horario agregado';
        redirect("/admin/profesionales/{$profesional_id}/agenda");
    }

    public function edit($profesional_id, $agenda_id) {
        $profesional = Profesional::find($profesional_id);
        $agenda = Agenda::find($agenda_id);
        
        View::render('admin/agendas/edit', [
            'profesional' => $profesional,
            'agenda' => $agenda,
            'pageTitle' => 'Editar Horario',
            'activePage' => 'profesionales'
        ]);
    }

    public function update($profesional_id, $agenda_id) {
        Agenda::update($agenda_id, [
            'dia_semana' => $_POST['dia_semana'],
            'hora_inicio' => $_POST['hora_inicio'],
            'hora_fin' => $_POST['hora_fin'],
            'duracion_minutos' => $_POST['duracion_minutos'] ?? 30,
            'activo' => $_POST['activo'] ?? 1
        ]);
        $_SESSION['success'] = 'Horario actualizado';
        redirect("/admin/profesionales/{$profesional_id}/agenda");
    }

    public function destroy($profesional_id, $agenda_id) {
        Agenda::delete($agenda_id);
        $_SESSION['success'] = 'Horario eliminado';
        redirect("/admin/profesionales/{$profesional_id}/agenda");
    }
}
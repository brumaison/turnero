<?php
namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Profesional;
use App\Models\Especialidad;

class ProfesionalesController {
    
    public function index() {
        $profesionales = Profesional::todos();
        View::render('admin/profesionales/index', [
            'activePage' => 'profesionales',
            'activeSubPage' => 'index',
            'profesionales' => $profesionales,
            'pageTitle' => 'Profesionales',
            'activePage' => 'profesionales'
        ]);
    }

    public function create() {
        $especialidades = Especialidad::all();
       // ProfesionalesController::create()
        View::render('admin/profesionales/create', [
            'activePage' => 'profesionales',
            'activeSubPage' => 'create',
            'pageTitle' => 'Nuevo Profesional',
            'activePage' => 'profesionales',
            'activeSubPage' => 'create',  // ← Nuevo
        ]);
    }

    public function store() {
        Profesional::create([
            'nombre' => $_POST['nombre'],
            'consultorio_default_id' => $_POST['consultorio_default_id'] ?? null,
            'duracion_default' => $_POST['duracion_default'] ?? 30,
            'especialidades' => $_POST['especialidades'] ?? []
        ]);
        $_SESSION['success'] = 'Profesional creado';
        redirect('/admin/profesionales');
    }

    public function edit($id) {
        $profesional = Profesional::find($id);
        $especialidades = Especialidad::all();
        $profesional_especialidades = Profesional::getEspecialidades($id);
        
        View::render('admin/profesionales/edit', [
            'activePage' => 'profesionales',
            'activeSubPage' => 'edit',
            'profesional' => $profesional,
            'especialidades' => $especialidades,
            'profesional_especialidades' => array_column($profesional_especialidades, 'id'),
            'pageTitle' => 'Editar Profesional',
            'activePage' => 'profesionales'
        ]);
    }

    public function update($id) {
        Profesional::update($id, [
            'nombre' => $_POST['nombre'],
            'consultorio_default_id' => $_POST['consultorio_default_id'] ?? null,
            'duracion_default' => $_POST['duracion_default'] ?? 30,
            'especialidades' => $_POST['especialidades'] ?? []
        ]);
        $_SESSION['success'] = 'Profesional actualizado';
        redirect('/admin/profesionales');
    }

    public function destroy($id) {
        Profesional::delete($id);
        $_SESSION['success'] = 'Profesional eliminado';
        redirect('/admin/profesionales');
    }

    // Ver agenda de un profesional
    public function agenda($id) {
        $profesional = Profesional::find($id);
        $agendas = \App\Models\Agenda::getByProfesional($id);
        
        View::render('admin/profesionales/agenda', [
            'profesional' => $profesional,
            'agendas' => $agendas,
            'pageTitle' => 'Agenda - ' . $profesional['nombre'],
            'activePage' => 'profesionales'
        ]);
    }
}
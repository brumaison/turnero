<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\View;
use App\Core\Flash;
use App\Models\Profesional;
use App\Models\Especialidad;
use App\Models\Consultorio; 

class ProfesionalesController extends Controller {
    
    public function index() {
        $profesionales = Profesional::todos();
        
        View::render('admin/profesionales/index', [
            'profesionales' => $profesionales,
            'pageTitle' => 'Profesionales',
            'activePage' => 'profesionales',
            'activeSubPage' => 'index'
        ]);
    }

    public function create() {
        $especialidades = Especialidad::all();
        $consultorios = Consultorio::todos();  // ← Fetch
        
        View::render('admin/profesionales/create', [
            'especialidades' => $especialidades,
            'consultorios' => $consultorios,
            'pageTitle' => 'Nuevo Profesional',
            'activePage' => 'profesionales',
            'activeSubPage' => 'create'
        ]);
    }

    public function store() {
        csrf_verify();
        
        // Validación
        if (empty($_POST['consultorio_default_id'])) {
            Flash::error('Debe seleccionar un consultorio');
            redirect('/admin/profesionales/create');
            return;
        }
        
        Profesional::createWithOperator([
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'nombre' => $_POST['nombre'],
            'consultorio_default_id' => (int)$_POST['consultorio_default_id'],
            'duracion_default' => $_POST['duracion_default'] ?? 30,
            'especialidades' => $_POST['especialidades'] ?? []
        ]);
        
        Flash::success('Profesional creado');
        redirect('/admin/profesionales');
    }

    public function edit($id) {
        $profesional = Profesional::findWithOperator($id);
        $especialidades = Especialidad::all();
        $profesional_especialidades = Profesional::getEspecialidades($id);
        $consultorios = Consultorio::todos();
        
        View::render('admin/profesionales/edit', [
            'profesional' => $profesional,
            'especialidades' => $especialidades,
            'consultorios' => $consultorios,
            'profesional_especialidades' => array_column($profesional_especialidades, 'id'),
            'pageTitle' => 'Editar Profesional',
            'activePage' => 'profesionales',
            'activeSubPage' => 'edit'
        ]);
    }

    public function update($id) {
        csrf_verify();
        
        // Validación
        if (empty($_POST['consultorio_default_id'])) {
            Flash::error('Debe seleccionar un consultorio');
            redirect("/admin/profesionales/{$id}/edit");
            return;
        }
        
        Profesional::updateWithOperator($id, [
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
            'nombre' => $_POST['nombre'],
            'consultorio_default_id' => (int)$_POST['consultorio_default_id'],
            'duracion_default' => $_POST['duracion_default'] ?? 30,
            'especialidades' => $_POST['especialidades'] ?? []
        ]);
        
        Flash::success('Profesional actualizado');
        redirect('/admin/profesionales');
    }

    public function destroy($id) {
        Profesional::delete($id);
        Flash::success('Profesional eliminado');
        redirect('/admin/profesionales');
    }

    public function agenda($id) {
        $profesional = Profesional::find($id);
        
        if (!$profesional) {
            Flash::error('Profesional no encontrado');
            redirect('/admin/profesionales');
            return;
        }
        
        $agendas = \App\Models\Agenda::getByProfesional($id);
        
        View::render('admin/profesionales/agenda', [
            'profesional' => $profesional,
            'agendas' => $agendas,
            'pageTitle' => 'Agenda - ' . $profesional['nombre'],
            'activePage' => 'profesionales'
        ]);
    }
}
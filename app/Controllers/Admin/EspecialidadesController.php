<?php
namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Flash;
use App\Core\Model;
use App\Models\Especialidad;

class EspecialidadesController {
    
    public function index() {
        $especialidades = Especialidad::all();
        View::render('admin/especialidades/index', [
            'especialidades' => $especialidades,
            'pageTitle' => 'Especialidades',
            'activePage' => 'especialidades'
        ]);
    }

    public function create() {
        View::render('admin/especialidades/create', [
            'pageTitle' => 'Nueva Especialidad',
            'activePage' => 'especialidades'
        ]);
    }

    public function store() {
        if (empty($_POST['nombre'])) {
            $_SESSION['error'] = 'Nombre requerido';
            redirect('/admin/especialidades/create');
        }
        
        Especialidad::create(['nombre' => $_POST['nombre']]);
        $_SESSION['success'] = 'Especialidad creada';
        redirect('/admin/especialidades');
    }

    public function edit($id) {
        $especialidad = Especialidad::find($id);
        View::render('admin/especialidades/edit', [
            'especialidad' => $especialidad,
            'pageTitle' => 'Editar Especialidad',
            'activePage' => 'especialidades'
        ]);
    }

    public function update($id) {
        Especialidad::update($id, ['nombre' => $_POST['nombre']]);
        $_SESSION['success'] = 'Especialidad actualizada';
        redirect('/admin/especialidades');
    }

public function destroy($id) {
    $stmt = Model::db()->prepare("
        SELECT COUNT(*) FROM profesional_especialidad WHERE especialidad_id = ?
    ");
    $stmt->execute([$id]);
    $cantidad = $stmt->fetchColumn();
    
    if ($cantidad > 0) {
        Flash::warning("Se eliminará de {$cantidad} profesionales");
    }
    
    Especialidad::delete($id);
    Flash::success('Especialidad eliminada');
    redirect('/admin/especialidades');
}
}
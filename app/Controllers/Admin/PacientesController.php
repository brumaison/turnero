<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\View;
use App\Models\Paciente;
use App\Core\Flash;

class PacientesController extends Controller {

    // Listar pacientes
    public function index() {
        $pacientes = Paciente::all();
        View::render('admin/pacientes/index', [
            'pageTitle' => 'Pacientes',
            'activePage' => 'pacientes',
            'pacientes' => $pacientes
        ]);
    }

    // Form crear
    public function create() {
        View::render('admin/pacientes/create', [
            'pageTitle' => 'Nuevo Paciente', 
            'activePage' => 'pacientes'
        ]);
    }

    // Guardar
    public function store() {
        // Validar DNI único
        if (Paciente::dniExiste($_POST['dni'])) {
            Flash::error('El DNI ya está registrado');
            redirect('/admin/pacientes/create');
        }
        
        Paciente::create($_POST);
        Flash::success('Paciente creado');
        redirect('/admin/pacientes');
    }

    // Form editar
    public function edit($id) {
        $paciente = Paciente::findById($id);
        if (!$paciente) redirect('/admin/pacientes');
        
        View::render('admin/pacientes/edit', [
            'pageTitle' => 'Editar Paciente',
            'paciente' => $paciente, 
            'activePage' => 'pacientes'
        ]);
    }

    // Actualizar
    public function update($id) {
        // Validar DNI único (excluyendo el actual)
        if (Paciente::dniExiste($_POST['dni'], $id)) {
            Flash::error('El DNI ya está registrado');
            redirect('/admin/pacientes/' . $id . '/edit');
        }
        
        Paciente::update($id, $_POST);
        Flash::success('Paciente actualizado');
        redirect('/admin/pacientes');
    }

    // Eliminar
    public function destroy($id) {
        Paciente::destroy($id);
        Flash::success('Paciente eliminado');
        redirect('/admin/pacientes');
    }

    // Historial clínico (solo lectura)
    public function historial($id) {
        $paciente = Paciente::findById($id);
        if (!$paciente) redirect('/admin/pacientes');
        
        $consultas = Paciente::getHistorial($id);
        
        View::render('admin/pacientes/historial', [
            'pageTitle' => 'Historial: ' . $paciente['apellido'] . ', ' . $paciente['nombre'],
            'paciente' => $paciente,
            'activePage' => 'pacientes',
            'consultas' => $consultas
        ]);
    }
}
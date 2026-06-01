<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\View;
use App\Core\Flash;
use App\Models\Operador;

class OperadoresController extends Controller {

    public function index() {
        $operadores = Operador::todos();

        View::render('admin/operadores/index', [
            'operadores' => $operadores,
            'pageTitle' => 'Operadores',
            'activePage' => 'operadores',
            'activeSubPage' => 'index'
        ]);
    }

    public function create() {
        $roles = Operador::getRoles();

        View::render('admin/operadores/create', [
            'roles' => $roles,
            'pageTitle' => 'Nuevo Operador',
            'activePage' => 'operadores',
            'activeSubPage' => 'create'
        ]);
    }

    public function store() {
        csrf_verify();

        if (empty($_POST['email']) || empty($_POST['password'])) {
            Flash::error('Email y contraseña son obligatorios');
            redirect('/admin/operadores/create');
            return;
        }

        if (Operador::emailExiste($_POST['email'])) {
            Flash::error('El email ya está registrado');
            redirect('/admin/operadores/create');
            return;
        }

        Operador::crear([
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role_id' => (int)($_POST['role_id'] ?? 0) ?: null
        ]);

        Flash::success('Operador creado');
        redirect('/admin/operadores');
    }

    public function edit($id) {
        $operador = Operador::find($id);
        if (!$operador) {
            Flash::error('Operador no encontrado');
            redirect('/admin/operadores');
            return;
        }

        $roles = Operador::getRoles();

        View::render('admin/operadores/edit', [
            'operador' => $operador,
            'roles' => $roles,
            'pageTitle' => 'Editar Operador',
            'activePage' => 'operadores',
            'activeSubPage' => 'edit'
        ]);
    }

    public function update($id) {
        csrf_verify();

        $operador = Operador::find($id);
        if (!$operador) {
            Flash::error('Operador no encontrado');
            redirect('/admin/operadores');
            return;
        }

        if (!empty($_POST['email']) && Operador::emailExiste($_POST['email'], $id)) {
            Flash::error('El email ya está registrado');
            redirect("/admin/operadores/{$id}/edit");
            return;
        }

        Operador::actualizar($id, [
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
            'role_id' => isset($_POST['role_id']) ? (int)$_POST['role_id'] : $operador['role_id']
        ]);

        Flash::success('Operador actualizado');
        redirect('/admin/operadores');
    }

    public function destroy($id) {
        $operador = Operador::find($id);
        if (!$operador) {
            Flash::error('Operador no encontrado');
            redirect('/admin/operadores');
            return;
        }

        if ($operador['id'] == $_SESSION['user_id']) {
            Flash::error('No podés eliminar tu propio usuario');
            redirect('/admin/operadores');
            return;
        }

        Operador::eliminar($id);
        Flash::success('Operador eliminado');
        redirect('/admin/operadores');
    }
}

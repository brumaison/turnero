<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Especialidades</h3>
        <a href="<?= baseUrl('/admin/especialidades/create') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i> Nueva
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead><tr><th>Nombre</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach ($especialidades as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['nombre']) ?></td>
                    <td>
                        <a href="<?= baseUrl('/admin/especialidades/'.$e['id'].'/edit') ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <a href="<?= baseUrl('/admin/especialidades/'.$e['id'].'/destroy') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
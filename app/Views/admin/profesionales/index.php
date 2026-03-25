
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Profesionales</h3>
        <a href="<?= baseUrl('/admin/profesionales/create') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i> Nuevo
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead><tr><th>Nombre</th><th>Especialidades</th><th>Agenda</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach ($profesionales as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['especialidades'] ?? 'Sin asignar') ?></td>
                    <td>
                        <a href="<?= baseUrl('/admin/profesionales/'.$p['id'].'/agenda') ?>" class="btn btn-sm btn-outline-info">
                            <i class="ti ti-calendar"></i> Ver Agenda
                        </a>
                    </td>
                    <td>
                        <a href="<?= baseUrl('/admin/profesionales/'.$p['id'].'/edit') ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <a href="<?= baseUrl('/admin/profesionales/'.$p['id'].'/destroy') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
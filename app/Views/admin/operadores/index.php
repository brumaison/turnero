<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Operadores</h3>
        <a href="<?= baseUrl('/admin/operadores/create') ?>" class="btn btn-primary">
            <i class="ti ti-plus"></i> Nuevo
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Vinculado a</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operadores as $o): ?>
                <tr>
                    <td><?= htmlspecialchars($o['email']) ?></td>
                    <td>
                        <span class="badge text-bg-<?= $o['role_slug'] === 'admin' ? 'danger' : ($o['role_slug'] === 'recepcion' ? 'warning' : 'info') ?>">
                            <?= htmlspecialchars($o['role_nombre'] ?? 'Sin rol') ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($o['profesional_nombre']): ?>
                            <span class="text-muted"><i class="ti ti-user-circle me-1"></i><?= htmlspecialchars($o['profesional_nombre']) ?></span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= baseUrl('/admin/operadores/'.$o['id'].'/edit') ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <?php if ($o['id'] != ($_SESSION['user_id'] ?? null)): ?>
                        <a href="<?= baseUrl('/admin/operadores/'.$o['id'].'/destroy') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este operador?')">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

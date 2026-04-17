<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pacientes</h3>
        <div class="card-actions">
            <?php if (($_SESSION['user_role_slug'] ?? '') !== 'medico'): ?>
            <a href="<?= baseUrl('/admin/pacientes/create') ?>" class="btn btn-primary">
                <i class="ti ti-plus"></i> Nuevo
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Buscador -->
        <div class="mb-3">
            <input type="text" id="buscarPaciente" class="form-control" placeholder="Buscar por nombre, apellido o DNI...">
        </div>

        <?php if (empty($pacientes)): ?>
        <div class="empty">
            <div class="empty-icon"><i class="ti ti-users"></i></div>
            <p class="empty-title h3">No hay pacientes registrados</p>
            <?php if (($_SESSION['user_role_slug'] ?? '') !== 'medico'): ?>
            <p class="empty-subtitle text-muted">Comenzá creando uno nuevo</p>
            <a href="<?= baseUrl('/admin/pacientes/create') ?>" class="btn btn-primary">Nuevo Paciente</a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table id="tablaPacientes" class="table card-table table-vcenter text-nowrap">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['dni']) ?></td>
                        <td>
                            <div class="fw-medium"><?= htmlspecialchars($p['apellido'] . ', ' . $p['nombre']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($p['telefono'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($p['email'] ?? '-') ?></td>
                        <td class="text-end">
                            <!-- Médico: solo historial -->
                            <?php if (($_SESSION['user_role_slug'] ?? '') === 'medico'): ?>
                                <a href="<?= baseUrl('/admin/pacientes/' . $p['id'] . '/historial') ?>" class="btn btn-info btn-sm" title="Ver Historial">
                                    <i class="ti ti-file-invoice"></i>
                                </a>
                            
                            <!-- Admin/Recepción: CRUD completo -->
                            <?php else: ?>
                                <a href="<?= baseUrl('/admin/pacientes/' . $p['id'] . '/historial') ?>" class="btn btn-info btn-sm" title="Historial Clínico">
                                    <i class="ti ti-file-invoice"></i>
                                </a>
                                <a href="<?= baseUrl('/admin/pacientes/' . $p['id'] . '/edit') ?>" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" onclick="eliminarPaciente(<?= $p['id'] ?>, '<?= addslashes($p['apellido'].', '.$p['nombre']) ?>')" title="Eliminar">
                                    <i class="ti ti-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    const table = $('#tablaPacientes').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' },
        order: [[1, 'asc']],
        pageLength: 10,
        responsive: true
    });

    // Buscador en tiempo real
    $('#buscarPaciente').on('keyup', function() {
        table.search(this.value).draw();
    });
});

function eliminarPaciente(id, nombre) {
    if (confirm('¿Eliminar a ' + nombre + '?\n\nEsta acción no se puede deshacer.')) {
        window.location.href = '<?= baseUrl('/admin/pacientes') ?>/' + id + '/destroy';
    }
}
</script>
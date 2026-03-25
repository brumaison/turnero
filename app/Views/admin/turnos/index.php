<div class="card">
    <div class="card-header">
        <h3 class="card-title">Turnos</h3>
        <div class="card-actions">
            <a href="<?= baseUrl('/admin/turnos/calendar') ?>" class="btn btn-outline-primary me-2">
                <i class="ti ti-calendar"></i> Ver Calendario
            </a>
            <a href="<?= baseUrl('/admin/turnos/create') ?>" class="btn btn-primary">
                <i class="ti ti-plus"></i> Nuevo Turno
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Filtros -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Desde</label>
                <input type="date" class="form-control" name="fecha_inicio" value="<?= $filtros['fecha_inicio'] ?? date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Hasta</label>
                <input type="date" class="form-control" name="fecha_fin" value="<?= $filtros['fecha_fin'] ?? date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Profesional</label>
                <select class="form-select" name="profesional_id">
                    <option value="">Todos</option>
                    <?php foreach ($profesionales as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= ($filtros['profesional_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-filter"></i> Filtrar
                </button>
            </div>
        </form>

        <?php if (empty($turnos)): ?>
        <div class="empty">
            <div class="empty-icon"><i class="ti ti-calendar-off" style="font-size:64px;color:#cbd5e1;"></i></div>
            <p class="empty-title h3">No hay turnos en este rango</p>
            <p class="empty-subtitle text-muted">Ajustá los filtros o creá un nuevo turno</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table id="tablaTurnos" class="table card-table table-vcenter text-nowrap">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Profesional</th>
                        <th>Consultorio</th>
                        <th>Estado</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($turnos as $t): ?>
                    <tr>
                        <td><span class="badge bg-blue-lt"><?= date('H:i', strtotime($t['fecha_hora'])) ?></span></td>
                        <td>
                            <div class="fw-medium"><?= htmlspecialchars($t['apellido'].', '.$t['nombre']) ?></div>
                            <div class="text-muted small"><?= htmlspecialchars($t['dni']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($t['profesional']) ?></td>
                        <td><?= htmlspecialchars($t['consultorio'] ?? '-') ?></td>
                        <td>
                            <span class="badge bg-<?= ['yellow-lt','green-lt','red-lt','gray-lt','blue-lt'][$t['estado_id']-1] ?>">
                                <?= ['Pendiente','Confirmado','Cancelado','Ausente','Realizado'][$t['estado_id']-1] ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-danger btn-sm" onclick="cancelarTurno(<?= $t['id'] ?>)">
                                <i class="ti ti-x"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tablaTurnos').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' },
        order: [[0, 'asc']],
        pageLength: 10
    });
});
function cancelarTurno(id) {
    if (confirm('¿Cancelar este turno?')) {
        // TODO: Implementar cancelación vía AJAX
        console.log('Cancelar:', id);
    }
}
</script>
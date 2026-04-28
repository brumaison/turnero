<div class="card">
    <div class="card-header">
        <h3 class="card-title">Turnos</h3>
        <div class="card-actions">
            <a href="<?= baseUrl('/admin/turnos/calendar') ?>" class="btn btn-outline-primary me-2">
                <i class="ti ti-calendar"></i> Calendario
            </a>
            <?php if (($_SESSION['user_role_slug'] ?? '') !== 'medico'): ?>
                <a href="<?= baseUrl('/admin/turnos/create') ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Nuevo
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Filtros -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label small">Desde</label>
                <input type="date" class="form-control form-control-sm" name="fecha_inicio" value="<?= $filtros['fecha_inicio'] ?? date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Hasta</label>
                <input type="date" class="form-control form-control-sm" name="fecha_fin" value="<?= $filtros['fecha_fin'] ?? date('Y-m-d') ?>">
            </div>
            <?php if (($_SESSION['user_role_slug'] ?? '') !== 'medico'): ?>
            <div class="col-md-3">
                <label class="form-label small">Profesional</label>
                <select class="form-select form-select-sm" name="profesional_id">
                    <option value="">Todos</option>
                    <?php foreach ($profesionales as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= ($filtros['profesional_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="ti ti-filter"></i> Filtrar
                </button>
            </div>
        </form>

        <?php if (empty($turnos)): ?>
        <div class="empty">
            <div class="empty-icon"><i class="ti ti-calendar-off"></i></div>
            <p class="empty-title h3">No hay turnos</p>
            <p class="empty-subtitle text-muted">Ajustá los filtros o creá un nuevo turno</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table id="tablaTurnos" class="table card-table table-vcenter text-nowrap">
                <thead>
                    <tr>
                        <th>Fecha</th>
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
                        <td>
                            <span class="badge bg-blue-lt">
                                <?= date('d/m/Y H:i', strtotime($t['fecha_hora'])) ?>
                            </span>
                        </td>
                        <td>
                            <div class="fw-medium"><?= htmlspecialchars($t['apellido'].', '.$t['nombre']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($t['dni']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($t['profesional']) ?></td>
                        <td><?= htmlspecialchars($t['consultorio_nombre'] ?? '-') ?></td>
                        <td>
                            <?php 
                            $estado_map = [];
                            foreach ($estados as $e) {
                                $estado_map[$e['id']] = $e;
                            }
                            $e = $estado_map[$t['estado_id']] ?? $estado_map[1];
                            ?>
                            <span class="badge" style="background-color: <?= $e['color'] ?>20; color: <?= $e['color'] ?>">
                                <?= htmlspecialchars($e['nombre']) ?>
                            </span>
                        </td>
                        <td class="text-end">
                        <?php if (($_SESSION['user_role_slug'] ?? '') === 'medico'): ?>
                            
                            <!-- Atender (solo si es del día y pendiente/confirmado) -->
                            <?php if (date('Y-m-d', strtotime($t['fecha_hora'])) === date('Y-m-d') && in_array($t['estado_id'], [1,2])): ?>
                                <a href="<?= baseUrl('/admin/consultas/' . $t['id'] . '/atender') ?>" class="btn btn-success btn-sm" title="Atender">
                                    <i class="ti ti-stethoscope"></i>
                                </a>
                            <?php endif; ?>
                            
                            <!-- 🔹 Ver historial (SIEMPRE visible para médico) -->
                            <a href="<?= baseUrl('/admin/pacientes/' . $t['paciente_id'] . '/historial') ?>" 
                            class="btn btn-sm btn-info" 
                            title="Ver Historial Clínico"
                            target="_blank">
                                <i class="ti ti-file-invoice"></i>
                            </a>
                            
                        <?php else: ?>
                            <!-- Admin/Recepción -->
                            <a href="<?= baseUrl('/admin/turnos/' . $t['id'] . '/edit') ?>" class="btn btn-primary btn-sm" title="Editar">
                                <i class="ti ti-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="cancelarTurno(<?= $t['id'] ?>)" title="Cancelar">
                                <i class="ti ti-x"></i>
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

<script>
$(document).ready(function() {
    $('#tablaTurnos').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' },
        order: [[0, 'asc']],
        pageLength: 10,
        responsive: true,
        ordering: false,  // ← AGREGAR ESTA LÍNEA
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 5, targets: -1 }
        ]
    });
});

function cancelarTurno(id) {
    if (confirm('¿Cancelar este turno?')) {
        // TODO: Implementar cancelación vía AJAX
        console.log('Cancelar:', id);
    }
}
</script>
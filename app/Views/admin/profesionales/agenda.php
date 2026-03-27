<div class="card">
    <div class="card-header">
        <h3 class="card-title">Agenda: <?= htmlspecialchars($profesional['nombre']) ?></h3>
        <div class="card-actions">
            <a href="<?= baseUrl('/admin/profesionales/' . $profesional['id'] . '/agenda/create') ?>" class="btn btn-primary">
                <i class="ti ti-plus"></i> Agregar Horario
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($agendas)): ?>
        <div class="alert alert-info">No hay horarios configurados. <a href="<?= baseUrl('/admin/profesionales/' . $profesional['id'] . '/agenda/create') ?>">Agregar uno</a>.</div>
        <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendas as $a): ?>
                <tr>
                    <td><?= ['','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'][$a['dia_semana']] ?></td>
                    <td><?= $a['hora_inicio'] ?></td>
                    <td><?= $a['hora_fin'] ?></td>
                    <td><?= $a['duracion_minutos'] ?> min</td>
                    <td><span class="badge bg-<?= $a['activo'] ? 'success' : 'secondary' ?>"><?= $a['activo'] ? 'Activo' : 'Inactivo' ?></span></td>
                    <td>
                        <a href="<?= baseUrl('/admin/profesionales/' . $profesional['id'] . '/agenda/' . $a['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                        <a href="<?= baseUrl('/admin/profesionales/' . $profesional['id'] . '/agenda/' . $a['id'] . '/destroy') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
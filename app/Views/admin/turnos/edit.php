
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Turno #<?= $turno['id'] ?></h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/turnos/'.$turno['id'].'/update') ?>">
            <?= csrf_field() ?>
            <!-- Paciente (solo lectura) -->
            <div class="mb-3">
                <label class="form-label">Paciente</label>
                <input type="text" class="form-control" 
                       value="<?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?>" 
                       disabled>
                <input type="hidden" name="paciente_id" value="<?= $turno['paciente_id'] ?>">
            </div>

            <!-- Profesional -->
            <div class="mb-3">
                <label class="form-label">Profesional</label>
                <select name="profesional_id" class="form-select" required>
                    <?php foreach ($profesionales as $p): ?>
                        <option value="<?= $p['id'] ?>" 
                                <?= $p['id'] == $turno['profesional_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Consultorio -->
            <div class="mb-3">
                <label class="form-label">Consultorio</label>
                <select name="consultorio_id" class="form-select">
                    <option value="">Sin asignar</option>
                    <?php foreach ($consultorios as $c): ?>
                        <option value="<?= $c['id'] ?>" 
                                <?= $c['id'] == $turno['consultorio_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fecha y Hora -->
            <div class="mb-3">
                <label class="form-label">Fecha y Hora</label>
                <input type="datetime-local" name="fecha_hora" class="form-control" 
                       value="<?= date('Y-m-d\TH:i', strtotime($turno['fecha_hora'])) ?>" required>
            </div>

            <!-- Duración -->
            <div class="mb-3">
                <label class="form-label">Duración (minutos)</label>
                <select name="duracion_minutos" class="form-select">
                    <option value="15" <?= $turno['duracion_minutos'] == 15 ? 'selected' : '' ?>>15</option>
                    <option value="30" <?= $turno['duracion_minutos'] == 30 ? 'selected' : '' ?>>30</option>
                    <option value="45" <?= $turno['duracion_minutos'] == 45 ? 'selected' : '' ?>>45</option>
                    <option value="60" <?= $turno['duracion_minutos'] == 60 ? 'selected' : '' ?>>60</option>
                </select>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado_id" class="form-select" required>
                    <?php foreach ($estados as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= $e['id'] == $turno['estado_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Observaciones -->
            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3"><?= htmlspecialchars($turno['observaciones']) ?></textarea>
            </div>

            <!-- Botones -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Guardar Cambios
                </button>
                <a href="<?= baseUrl('/admin/turnos') ?>" class="btn btn-secondary">
                    <i class="ti ti-x me-1"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

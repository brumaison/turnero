<div class="card">
    <div class="card-header"><h3 class="card-title">Editar Profesional</h3></div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/profesionales/'.$profesional['id'].'/update') ?>">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($profesional['nombre']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Especialidades</label>
                <select class="form-select" name="especialidades[]" multiple required>
                    <?php foreach ($especialidades as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= in_array($e['id'], $profesional_especialidades) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Duración por defecto (minutos)</label>
                <input type="number" class="form-control" name="duracion_default" value="<?= $profesional['duracion_default'] ?? 30 ?>" min="15" max="120">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="<?= baseUrl('/admin/profesionales') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
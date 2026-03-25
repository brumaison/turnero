<div class="card">
    <div class="card-header"><h3 class="card-title">Nuevo Profesional</h3></div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/profesionales/store') ?>">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Especialidades</label>
                <select class="form-select" name="especialidades[]" multiple required>
                    <?php foreach ($especialidades as $e): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Ctrl+Click para seleccionar múltiples</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Duración por defecto (minutos)</label>
                <input type="number" class="form-control" name="duracion_default" value="30" min="15" max="120">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?= baseUrl('/admin/profesionales') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
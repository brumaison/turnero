<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nuevo Profesional</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/profesionales/store') ?>">
            <?= csrf_field() ?>
            
            <!-- Datos del Profesional -->
            <h5 class="mb-3">Datos del Profesional</h5>
            
            <div class="mb-3">
                <label class="form-label">Nombre completo *</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Consultorio default</label>
                <select class="form-select" name="consultorio_default_id" required>
                    <option value="">Sin default</option>
                    <?php foreach ($consultorios as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Duración por defecto (minutos)</label>
                <input type="number" class="form-control" name="duracion_default" value="30" min="15" max="120">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Especialidades</label>
                <select class="form-select" name="especialidades[]" multiple>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Ctrl+Click para seleccionar múltiples</small>
            </div>
            
            <!-- Datos de Acceso (Login) -->
            <hr class="my-4">
            <h5 class="mb-3">Acceso al sistema</h5>
            
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Contraseña *</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            
            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?= baseUrl('/admin/profesionales') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
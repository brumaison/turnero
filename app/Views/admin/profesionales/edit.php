<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Profesional</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/profesionales/'.$profesional['id'].'/update') ?>">
            <?= csrf_field() ?>
            
            <!-- Datos del Profesional -->
            <h5 class="mb-3">Datos del Profesional</h5>
            
            <div class="mb-3">
                <label class="form-label">Nombre completo *</label>
                <input type="text" class="form-control" name="nombre" 
                       value="<?= htmlspecialchars($profesional['nombre']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Consultorio default</label>
                <select class="form-select" name="consultorio_default_id" required>
                    <option value="">Sin default</option>
                    <?php foreach ($consultorios as $c): ?>
                        <option value="<?= $c['id'] ?>" 
                            <?= $profesional['consultorio_default_id'] == $c['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Duración por defecto (minutos)</label>
                <input type="number" class="form-control" name="duracion_default" 
                       value="<?= $profesional['duracion_default'] ?? 30 ?>" min="15" max="120">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Especialidades</label>
                <select class="form-select" name="especialidades[]" multiple>
                    <?php foreach ($especialidades as $e): ?>
                        <option value="<?= $e['id'] ?>" 
                            <?= in_array($e['id'], $profesional_especialidades) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Ctrl+Click para seleccionar múltiples</small>
            </div>
            
            <!-- Datos de Acceso (Login) -->
            <hr class="my-4">
            <h5 class="mb-3">Acceso al sistema</h5>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" 
                       value="<?= htmlspecialchars($profesional['email'] ?? '') ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Contraseña <small class="text-muted">(vacío = no cambiar)</small></label>
                <input type="password" class="form-control" name="password" placeholder="Nueva contraseña">
            </div>
            
            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="<?= baseUrl('/admin/profesionales') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
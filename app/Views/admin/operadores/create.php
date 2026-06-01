<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nuevo Operador</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/operadores/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label required">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label required">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select class="form-select" name="role_id">
                    <option value="">Sin rol</option>
                    <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Los roles determinan los permisos de acceso</small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?= baseUrl('/admin/operadores') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

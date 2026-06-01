<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Operador</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/operadores/'.$operador['id'].'/update') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label required">Email</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($operador['email']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña <small class="text-muted">(vacío = no cambiar)</small></label>
                <input type="password" class="form-control" name="password" placeholder="Nueva contraseña">
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select class="form-select" name="role_id">
                    <option value="">Sin rol</option>
                    <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= $operador['role_id'] == $r['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="<?= baseUrl('/admin/operadores') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

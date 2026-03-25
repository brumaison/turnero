<div class="card">
    <div class="card-header"><h3 class="card-title">Nueva Especialidad</h3></div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/especialidades/store') ?>">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?= baseUrl('/admin/especialidades') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Editar Paciente</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/pacientes/' . $paciente['id'] . '/update') ?>">           
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">DNI *</label>
                        <input type="text" name="dni" class="form-control" value="<?= htmlspecialchars($paciente['dni']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($paciente['telefono'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($paciente['email'] ?? '') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Apellido *</label>
                        <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($paciente['apellido']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($paciente['nombre']) ?>" required>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i> Actualizar</button>
                <a href="<?= baseUrl('/admin/pacientes') ?>" class="btn btn-secondary"><i class="ti ti-x"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
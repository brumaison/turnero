<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nuevo Paciente</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/pacientes/store') ?>">
            
            <div class="row">
                <!-- DNI -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">DNI *</label>
                        <input type="text" name="dni" class="form-control" required placeholder="Ej: 12345678">
                    </div>
                </div>

                <!-- Teléfono -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" placeholder="Ej: 11-2345-6789">
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Ej: paciente@email.com">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Apellido -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Apellido *</label>
                        <input type="text" name="apellido" class="form-control" required placeholder="Ej: Pérez">
                    </div>
                </div>

                <!-- Nombre -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="nombre" class="form-control" required placeholder="Ej: Juan">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check"></i> Guardar
                </button>
                <a href="<?= baseUrl('/admin/pacientes') ?>" class="btn btn-secondary">
                    <i class="ti ti-x"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
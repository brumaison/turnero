<div class="card">
    <div class="card-header">
        <h3 class="card-title">Atender Turno</h3>
    </div>
    <div class="card-body">
        <!-- Info del turno -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Paciente</label>
                    <div class="fw-bold"><?= htmlspecialchars($turno['apellido'] . ', ' . $turno['nombre']) ?></div>
                    <small class="text-muted">DNI: <?= htmlspecialchars($turno['dni']) ?></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Fecha y Hora</label>
                    <div class="fw-bold"><?= date('d/m/Y H:i', strtotime($turno['fecha_hora'])) ?></div>
                </div>
            </div>
        </div>

        <form method="POST" action="<?= baseUrl('/admin/consultas/store') ?>">
            <input type="hidden" name="turno_id" value="<?= $turno['id'] ?>">
            
            <!-- Diagnóstico -->
            <div class="mb-3">
                <label class="form-label">Diagnóstico</label>
                <textarea name="diagnostico" class="form-control" rows="3" placeholder="Diagnóstico principal..."></textarea>
            </div>

            <!-- Notas de la consulta -->
            <div class="mb-3">
                <label class="form-label">Notas de la Consulta</label>
                <textarea name="notas" class="form-control" rows="5" placeholder="Observaciones, tratamiento indicado, etc..."></textarea>
                <small class="text-muted">Estas notas son parte de la historia clínica del paciente</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check"></i> Marcar como Realizado
                </button>
                <a href="<?= baseUrl('/admin/turnos') ?>" class="btn btn-secondary">
                    <i class="ti ti-x"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
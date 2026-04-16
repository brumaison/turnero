<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detalle de Consulta</h3>
    </div>
    <div class="card-body">
        <!-- Info básica -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Paciente</label>
                    <div class="fw-bold"><?= htmlspecialchars(trim(($paciente_apellido ?? '') . ' ' . ($paciente_nombre ?? ''))) ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Fecha de Atención</label>
                    <div class="fw-bold"><?= date('d/m/Y H:i', strtotime($consulta['created_at'])) ?></div>
                </div>
            </div>
        </div>

        <!-- Diagnóstico -->
        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <div class="form-control-plaintext fw-medium"><?= nl2br(htmlspecialchars($consulta['diagnostico'] ?? 'Sin diagnóstico')) ?></div>
        </div>

        <!-- Notas -->
        <div class="mb-4">
            <label class="form-label">Notas de la Consulta</label>
            <div class="form-control-plaintext"><?= nl2br(htmlspecialchars($consulta['notas'] ?? 'Sin notas')) ?></div>
        </div>

        <div class="d-flex gap-2">
            <a href="<?= baseUrl('/admin/turnos') ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Volver a Turnos
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="ti ti-file-invoice me-2"></i>
            Historial Clínico
        </h3>
    </div>
    <div class="card-body">
        
        <!-- Datos del paciente -->
        <div class="row mb-4 pb-3 border-bottom">
            <div class="col-md-3">
                <small class="text-muted d-block">Paciente</small>
                <div class="fw-bold"><?= htmlspecialchars($paciente['apellido'] . ', ' . $paciente['nombre']) ?></div>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">DNI</small>
                <div><?= htmlspecialchars($paciente['dni']) ?></div>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Teléfono</small>
                <div><?= htmlspecialchars($paciente['telefono'] ?? '-') ?></div>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block">Email</small>
                <div><?= htmlspecialchars($paciente['email'] ?? '-') ?></div>
            </div>
        </div>

        <?php if (empty($consultas)): ?>
        <div class="empty py-5">
            <div class="empty-icon text-muted"><i class="ti ti-file-invoice-off"></i></div>
            <p class="empty-title h4">Sin consultas registradas</p>
            <p class="empty-subtitle text-muted">Este paciente aún no tiene consultas en el sistema</p>
        </div>
        <?php else: ?>
        
        <h5 class="mb-3">Consultas (<?= count($consultas) ?>)</h5>
        
        <ul class="timeline timeline-simple">
            <?php foreach ($consultas as $c): ?>
            <li class="timeline-event">
                <div class="timeline-event-icon bg-blue-lt text-blue">
                    <i class="ti ti-stethoscope"></i>
                </div>
                <div class="card timeline-event-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">
                                <?= htmlspecialchars($c['profesional']) ?>
                            </h5>
                            <span class="badge bg-blue-lt text-blue">
                                <?= date('d/m/Y H:i', strtotime($c['fecha_hora'])) ?>
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted fw-medium">Diagnóstico:</small>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($c['diagnostico'] ?? 'Sin diagnóstico')) ?></p>
                        </div>
                        
                        <?php if (!empty($c['notas'])): ?>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted fw-medium">
                                <i class="ti ti-note me-1"></i>Notas:
                            </small>
                            <p class="mb-0 text-secondary small"><?= nl2br(htmlspecialchars($c['notas'])) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        
        <?php endif; ?>

        <div class="mt-4 pt-3 border-top">
            <a href="<?= baseUrl('/admin/pacientes') ?>" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i> Volver a Pacientes
            </a>
        </div>
    </div>
</div>
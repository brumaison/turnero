<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $pageTitle ?></h3>
        <?php if (($_SESSION['user_role_slug'] ?? '') !== 'medico'): ?>
        <div class="card-actions">
            <select class="form-select" id="filtro_profesional" style="min-width:200px">
                <option value="">Todos los profesionales</option>
                <?php foreach ($profesionales as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal Único para Turnos -->
<div class="modal modal-blur fade" id="modalTurno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle del Turno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalTurnoId">
                <div class="mb-3">
                    <label class="form-label text-muted">Paciente</label>
                    <div id="modalPaciente" class="fw-bold"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Profesional</label>
                    <div id="modalProfesional"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Fecha y Hora</label>
                    <div id="modalFecha"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Estado</label>
                    <span id="modalEstado" class="badge"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Observaciones</label>
                    <div id="modalObservaciones" class="text-muted small"></div>
                </div>
            </div>
            <div class="modal-footer">
            <a href="#" id="btnHistorial" class="btn btn-info">
                <i class="ti ti-file-invoice"></i> Ver Historial
            </a>
            <a href="#" id="btnEditar" class="btn btn-primary">
                <i class="ti ti-edit"></i> Editar
            </a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>




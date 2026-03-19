<div class="row row-deck row-cards mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Turnos Hoy</div>
                    <div class="ms-auto lh-1">
                        <i class="ti ti-calendar text-muted"></i>
                    </div>
                </div>
                <div class="h1 mb-3">0</div>
                <div class="d-flex mb-2">
                    <div class="text-muted">Pendientes</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Agrega más cards si quieres -->
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Turnos del Día</h3>
        <div class="card-actions">
            <a href="#" class="btn btn-primary">
                <i class="ti ti-plus"></i> Nuevo Turno
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($turnos)): ?>
            <div class="empty">
                <div class="empty-icon">
                    <i class="ti ti-calendar-off" style="font-size: 64px; color: #cbd5e1;"></i>
                </div>
                <p class="empty-title h3">No hay turnos para hoy</p>
                <p class="empty-subtitle text-muted">
                    Los turnos que reserves aparecerán aquí
                </p>
                <div class="empty-action">
                    <a href="#" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Crear primer turno
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Profesional</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turnos as $turno): ?>
                        <tr>
                            <td><span class="badge bg-blue-lt"><?= date('H:i', strtotime($turno['fecha_hora'])) ?></span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <div class="fw-medium"><?= $turno['apellido'] ?>, <?= $turno['nombre'] ?></div>
                                        <div class="text-muted"><?= $turno['dni'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?= $turno['profesional'] ?></td>
                            <td>
                                <span class="badge bg-yellow-lt">Pendiente</span>
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-danger btn-sm">Cancelar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
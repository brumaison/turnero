<style>
.fc-event { cursor: pointer; }
</style>
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
                <a href="#" id="btnEditar" class="btn btn-primary">
                    <i class="ti ti-edit"></i> Editar
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const modalTurno = new bootstrap.Modal(document.getElementById('modalTurno'));
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        
        eventDidMount: function(info) {
            new bootstrap.Popover(info.el, {
                title: info.event.title,
                content: `${info.event.extendedProps.paciente}<br>${info.event.start.toLocaleString('es-AR')}`,
                trigger: 'hover',
                placement: 'top',
                container: 'body'
            });
        },
        
        eventClick: function(info) {
            const props = info.event.extendedProps;
            const estados = ['Pendiente','Confirmado','Cancelado','Ausente','Realizado'];
            const colores = ['yellow-lt','green-lt','red-lt','gray-lt','blue-lt'];
            
            document.getElementById('modalTurnoId').value = info.event.id;
            document.getElementById('modalPaciente').textContent = props.paciente || 'N/A';
            document.getElementById('modalProfesional').textContent = props.profesional || 'N/A';
            document.getElementById('modalFecha').textContent = info.event.start.toLocaleString('es-AR');
            document.getElementById('modalEstado').textContent = estados[props.estado-1] || 'N/A';
            document.getElementById('modalEstado').className = 'badge bg-' + (colores[props.estado-1] || 'yellow-lt');
            document.getElementById('modalObservaciones').textContent = props.observaciones || 'Sin observaciones';
            document.getElementById('btnEditar').href = '<?= baseUrl('/admin/turnos') ?>/' + info.event.id + '/edit';
            
            modalTurno.show();
        },
        
        events: function(fetchInfo, successCallback) {
            const filtro = document.getElementById('filtro_profesional');
            const profesionalId = filtro ? filtro.value : '';
            fetch('<?= baseUrl('/admin/turnos/get-events') ?>?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr + (profesionalId ? '&profesional_id=' + profesionalId : ''))
                .then(response => response.json())
                .then(data => successCallback(data));
        },
    });
    
    calendar.render();
    
    const filtroProfesional = document.getElementById('filtro_profesional');
    if (filtroProfesional) {
        filtroProfesional.addEventListener('change', function() {
            calendar.refetchEvents();
        });
    }
});
</script>
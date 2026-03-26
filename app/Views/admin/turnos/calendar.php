<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $pageTitle ?></h3>
        <div class="card-actions">
            <select class="form-select" id="filtro_profesional" style="min-width:200px">
                <option value="">Todos los profesionales</option>
                <?php foreach ($profesionales as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        
        // 👇 POPOVER CON INFO DEL TURNO (HOVER)
        eventDidMount: function(info) {
            new bootstrap.Popover(info.el, {
                title: info.event.title,
                content: function() {
                    const props = info.event.extendedProps;
                    return `
                        <small class="text-muted">
                        <strong>Paciente:</strong> ${props.paciente || 'N/A'}<br>
                        <strong>Profesional:</strong> ${props.profesional || 'N/A'}<br>
                        <strong>Fecha:</strong> ${info.event.start.toLocaleString('es-AR')}<br>
                        <strong>Estado:</strong> ${['Pendiente','Confirmado','Cancelado','Ausente','Realizado'][props.estado-1] || 'N/A'}
                        </small>
                    `;
                },
                trigger: 'hover',
                placement: 'top',
                html: true,
                container: 'body'
            });
        },
        
        events: function(fetchInfo, successCallback) {
            const profesionalId = document.getElementById('filtro_profesional').value;
            fetch('<?= baseUrl('/admin/turnos/get-events') ?>?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr + (profesionalId ? '&profesional_id=' + profesionalId : ''))
                .then(response => response.json())
                .then(data => successCallback(data));
        },
        dateClick: function(info) {
            window.location.href = '<?= baseUrl('/admin/turnos/create') ?>?fecha=' + info.dateStr;
        },
        eventClick: function(info) {
            if (confirm('¿Editar este turno?')) {
                window.location.href = '<?= baseUrl('/admin/turnos') ?>/' + info.event.id + '/edit';
            }
        }
    });
    
    calendar.render();
    
    // Recargar al cambiar profesional
    document.getElementById('filtro_profesional').addEventListener('change', function() {
        calendar.refetchEvents();
    });
});
</script>
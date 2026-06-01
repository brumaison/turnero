                </div> <!-- /.container-fluid -->
            </div> <!-- /.page-body -->
        </div> <!-- /.page-wrapper -->
    </div> <!-- /.page -->

    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>
    <script>
    // Exponer bootstrap inmediatamente (Tabler JS ya cargó)
    if (typeof window.bootstrap === 'undefined' && typeof tabler !== 'undefined' && tabler.bootstrap) {
        window.bootstrap = tabler.bootstrap;
    }
    </script>
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        // Select2 en todos los .form-select
        $('.form-select').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('body')
        });
    });
    </script>
    <script>
    const USER_ROLE = '<?= $_SESSION['user_role_slug'] ?? '' ?>';
    const HOY = '<?= date('Y-m-d') ?>';
</script>
<style>
.fc-timegrid-event {
    padding: 6px 8px !important;
    font-size: 0.9rem !important;
    line-height: 1.4 !important;
    border-radius: 4px !important;
}
.fc-timegrid-slot {
    height: 4rem !important;
}
.fc-timegrid-slot-label {
    font-size: 0.85rem !important;
    padding: 4px !important;
}
.fc-event-title {
    font-weight: 600 !important;
    font-size: 0.85rem !important;
}
.fc-timegrid-now-indicator-line {
    border-color: #ff0000 !important;
    border-width: 2px !important;
}
.fc .fc-timegrid-slot-lane {
    border-color: #e9ecef !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
    const modalTurno = new bootstrap.Modal(document.getElementById('modalTurno'));
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridDay',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotMinTime: '<?= substr($horarioSede['apertura'] ?? '08:00:00', 0, 5) ?>',
        slotMaxTime: '<?= substr($horarioSede['cierre'] ?? '18:00:00', 0, 5) ?>',
        slotDuration: '00:30:00',
        slotLabelInterval: '01:00',
        height: 'auto',
        eventDisplay: 'block',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        
        eventDidMount: function(info) {
            const duracion = info.event.extendedProps.duracion_minutos || 30;
            new bootstrap.Popover(info.el, {
                title: info.event.title,
                content: `${info.event.extendedProps.paciente} - ${info.event.extendedProps.fecha_hora_formatted} (${duracion} min)`,
                trigger: 'hover',
                placement: 'top',
                container: 'body'
            });
        },
        
        eventClick: function(info) {
            const props = info.event.extendedProps;
            const ESTADOS = <?= json_encode($estados ?? []) ?>;

                        
            document.getElementById('modalTurnoId').value = info.event.id;            
            document.getElementById('btnHistorial').href = '<?= baseUrl('/admin/pacientes') ?>/' + props.paciente_id + '/historial';
            document.getElementById('modalPaciente').textContent = props.paciente || 'N/A';
            document.getElementById('modalProfesional').textContent = props.profesional || 'N/A';
            document.getElementById('modalFecha').textContent = info.event.extendedProps.fecha_hora_formatted;
            document.getElementById('modalDuracion').textContent = (props.duracion_minutos || 30) + ' minutos';
            const estado = ESTADOS.find(e => e.id == props.estado);
            document.getElementById('modalEstado').textContent = estado?.nombre || 'N/A';
            document.getElementById('modalEstado').className = 'badge';
            document.getElementById('modalEstado').style.backgroundColor = (estado?.color || '#ccc') + '20';
            document.getElementById('modalEstado').style.color = estado?.color || '#666';
            document.getElementById('modalObservaciones').textContent = info.event.extendedProps.observaciones || 'Sin observaciones';
            
            // 🔹 Link según rol + validación día actual para médico
            const btnEditar = document.getElementById('btnEditar');
            const fechaTurno = info.event.start.toISOString().split('T')[0];
            
            if (USER_ROLE === 'medico') {
                if (fechaTurno === HOY && [1,2].includes(props.estado)) {
                    btnEditar.href = '<?= baseUrl('/admin/consultas') ?>/' + info.event.id + '/atender';
                    btnEditar.innerHTML = '<i class="ti ti-stethoscope"></i> Atender';
                    btnEditar.className = 'btn btn-success';
                    btnEditar.style.display = 'inline-block';
                } else {
                    btnEditar.style.display = 'none'; // No puede atender
                }
            } else {
                // Admin/Recepción: siempre puede editar
                btnEditar.href = '<?= baseUrl('/admin/turnos') ?>/' + info.event.id + '/edit';
                btnEditar.innerHTML = '<i class="ti ti-edit"></i> Editar';
                btnEditar.className = 'btn btn-primary';
                btnEditar.style.display = 'inline-block';
            }
            
            modalTurno.show();
        },
        
        events: function(fetchInfo, successCallback) {
            const profesionalId = $('#filtro_profesional').val() || '';
            const especialidadId = $('#filtro_especialidad').val() || '';
            let url = '<?= baseUrl('/admin/turnos/get-events') ?>?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr;
            if (profesionalId) url += '&profesional_id=' + profesionalId;
            if (especialidadId) url += '&especialidad_id=' + especialidadId;
            fetch(url)
                .then(response => response.json())
                .then(data => successCallback(data));
        },
    });
    
    calendar.render();
    
    const filtroProfesional = $('#filtro_profesional');
    if (filtroProfesional.length) {
        filtroProfesional.on('change', function() {
            calendar.refetchEvents();
        });
    }

    const filtroEspecialidad = $('#filtro_especialidad');
    if (filtroEspecialidad.length) {
        filtroEspecialidad.on('change', function() {
            const espId = String($(this).val());
            if (espId) {
                $('#filtro_profesional option').each(function() {
                    const espIds = String($(this).data('especialidades') || '');
                    $(this).toggle(!espId || espIds.split(',').includes(espId));
                });
                $('#filtro_profesional').val('').trigger('change');
            } else {
                $('#filtro_profesional option').show();
                $('#filtro_profesional').val('');
            }
            calendar.refetchEvents();
        });
    }
});
</script>
</body>
</html>
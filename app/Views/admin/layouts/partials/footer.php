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
        $('.form-select').select2({ theme: 'bootstrap-5' });
    });
    </script>
    <script>
    const USER_ROLE = '<?= $_SESSION['user_role_slug'] ?? '' ?>';
    const HOY = '<?= date('Y-m-d') ?>';
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
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
                content: `${info.event.extendedProps.paciente} - ${info.event.extendedProps.fecha_hora_formatted}`,
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
</body>
</html>
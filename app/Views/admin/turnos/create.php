<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Nuevo Turno</h3>
        <div class="d-flex gap-2">
            <!-- Toggle modo de búsqueda -->
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="modo_busqueda" 
                       id="modo_profesional" value="profesional" checked>
                <label class="btn btn-outline-primary btn-sm" for="modo_profesional">
                    <i class="ti ti-user"></i> Profesional
                </label>
                
                <input type="radio" class="btn-check" name="modo_busqueda" 
                       id="modo_especialidad" value="especialidad">
                <label class="btn btn-outline-primary btn-sm" for="modo_especialidad">
                    <i class="ti ti-stethoscope"></i> Especialidad
                </label>
            </div>
            
            <button type="button" class="btn btn-outline-warning btn-sm" id="btn-sobreturno">
                ⚠️ Sobreturno
            </button>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Paso 1: Búsqueda por Especialidad -->
        <div id="step-especialidad" class="d-none">
            <div class="mb-3">
                <label class="form-label required">Especialidad</label>
                <select class="form-select" id="select_especialidad">
                    <option value="">Seleccionar...</option>
                    <?php foreach ($especialidades as $e): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Contenedor de horarios por especialidad -->
            <div id="contenedor-horarios-especialidad" class="d-none">
                <h5 class="mb-3">Próximos horarios disponibles</h5>
                <div id="lista-horarios-especialidad" class="space-y-3"></div>
            </div>
        </div>

        <!-- Paso 2: Selección de disponibilidad (flujo normal por profesional) -->
        <div id="step-disponibilidad">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Consultorio (opcional)</label>
                    <select class="form-select" id="filtro_consultorio">
                        <option value="">Todos</option>
                        <?php foreach ($consultorios as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Profesional</label>
                    <select class="form-select" id="select_profesional" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach ($profesionales as $p): ?>
                        <option value="<?= $p['id'] ?>" data-consultorio="<?= $p['consultorio_default_id'] ?? '' ?>">
                            <?= htmlspecialchars($p['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Contenedor de días disponibles -->
            <div id="contenedor-dias" class="d-none">
                <h5 class="mb-3">Días disponibles</h5>
                <div id="lista-dias" class="space-y-3"></div>
            </div>
        </div>

        <!-- Paso 3: Formulario sobreturno (oculto por defecto) -->
        <div id="step-sobreturno" class="d-none">
            <div class="alert alert-warning">
                <strong>⚠️ Sobreturno</strong><br>
                <small>Este turno se creará fuera de la agenda configurada. Requiere confirmación.</small>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label required">Profesional</label>
                    <select class="form-select" id="sobreturno_profesional" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach ($profesionales as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Fecha y Hora</label>
                    <input type="datetime-local" class="form-control" id="sobreturno_fecha_hora" required>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" id="btn-confirmar-sobreturno">Continuar</button>
                <button type="button" class="btn btn-secondary" id="btn-cancelar-sobreturno">Volver</button>
            </div>
        </div>

        <!-- Paso 4: Formulario de confirmación (oculto hasta seleccionar horario) -->
        <div id="step-formulario" class="d-none">
            <form method="POST" action="<?= baseUrl('/admin/turnos/store') ?>" id="form-turno">
                <?= csrf_field() ?>
                
                <!-- Datos preseleccionados (hidden) -->
                <input type="hidden" name="profesional_id" id="form_profesional_id">
                <input type="hidden" name="fecha_hora" id="form_fecha_hora">
                <input type="hidden" name="consultorio_id" id="form_consultorio_id">
                <input type="hidden" name="sobreturno" id="form_sobreturno" value="0">
                
                <div class="alert alert-info mb-3">
                    <strong>Turno seleccionado:</strong><br>
                    <span id="resumen-turno"></span>
                </div>

                <!-- Alerta sobreturno -->
                <div id="box-sobreturno" class="alert alert-warning d-none mb-3">
                    <small>⚠️ Este horario está fuera de la agenda configurada</small>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="check_sobreturno" name="sobreturno_check" value="1">
                        <label class="form-check-label" for="check_sobreturno">
                            Confirmo que deseo crear este sobreturno
                        </label>
                    </div>
                </div>

                <!-- Toggle Paciente -->
                <div class="mb-3">
                    <label class="form-label required">Tipo de Paciente</label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="tipo_paciente" id="paciente_existente" value="existente" checked>
                        <label class="btn btn-outline-primary" for="paciente_existente">Buscar Existente</label>
                        <input type="radio" class="btn-check" name="tipo_paciente" id="paciente_nuevo" value="nuevo">
                        <label class="btn btn-outline-primary" for="paciente_nuevo">Crear Nuevo</label>
                    </div>
                </div>

                <!-- Paciente Existente -->
                <div id="box_paciente_existente">
                    <div class="mb-3">
                        <label class="form-label required">Paciente</label>
                        <input type="text" class="form-control" id="paciente" placeholder="DNI o nombre...">
                        <input type="hidden" name="paciente_id" id="paciente_id">
                        <div id="sugerenciasPacientes" class="dropdown-menu w-100"></div>
                    </div>
                </div>

                <!-- Paciente Nuevo -->
                <div id="box_paciente_nuevo" class="d-none">
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label required">DNI</label>
                            <input type="text" class="form-control" name="nuevo_paciente_dni">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label required">Apellido, Nombre</label>
                            <input type="text" class="form-control" name="nuevo_paciente_nombre">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="nuevo_paciente_email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="nuevo_paciente_telefono">
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" name="observaciones" rows="2"></textarea>
                </div>

                <!-- Duración (oculta, valor por defecto 30) -->
                <input type="hidden" name="duracion_minutos" value="30">

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Confirmar Turno</button>
                    <button type="button" class="btn btn-secondary" id="btn-volver">Volver</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

<script>
$(document).ready(function() {
    // 🔹 Helper: Formatear fecha JS a formato MySQL SIN conversión UTC
    function formatLocalDateTime(dateObj) {
        const pad = (n) => String(n).padStart(2, '0');
        return `${dateObj.getFullYear()}-${pad(dateObj.getMonth()+1)}-${pad(dateObj.getDate())} ` +
               `${pad(dateObj.getHours())}:${pad(dateObj.getMinutes())}:${pad(dateObj.getSeconds())}`;
    }

    // 🔹 Helper: Formatear para mostrar en resumen (locale AR)
    function formatForDisplay(dateObj) {
        const fecha = dateObj.toLocaleDateString('es-AR', { weekday: 'long', day: 'numeric', month: 'numeric' });
        const hora = dateObj.toLocaleTimeString('es-AR', { hour: '2-digit', minute: '2-digit' });
        return `${fecha} ${hora}`;
    }

    // Init Select2
    $('.form-select').select2({ theme: 'bootstrap-5' });

    // Mínimo fecha para sobreturno (ahora, en hora local)
    const now = new Date();
    const minLocal = now.getFullYear() + '-' + 
                     String(now.getMonth()+1).padStart(2,'0') + '-' + 
                     String(now.getDate()).padStart(2,'0') + 'T' + 
                     String(now.getHours()).padStart(2,'0') + ':' + 
                     String(now.getMinutes()).padStart(2,'0');
    document.getElementById('sobreturno_fecha_hora').min = minLocal;

    // ─────────────────────────────────────────────────────────────
    // Toggle entre Profesional y Especialidad
    // ─────────────────────────────────────────────────────────────

    $('input[name="modo_busqueda"]').on('change', function() {
        const esEspecialidad = $('#modo_especialidad').is(':checked');
        
        if (esEspecialidad) {
            $('#step-disponibilidad').addClass('d-none');
            $('#step-especialidad').removeClass('d-none');
            $('#step-sobreturno').addClass('d-none');
        } else {
            $('#step-disponibilidad').removeClass('d-none');
            $('#step-especialidad').addClass('d-none');
            $('#step-sobreturno').addClass('d-none');
        }
        
        $('#step-formulario').addClass('d-none');
    });

    // Buscar horarios por especialidad
    $('#select_especialidad').on('change', function() {
        const especialidadId = $(this).val();
        
        if (!especialidadId) {
            $('#contenedor-horarios-especialidad').addClass('d-none');
            return;
        }
        
        $('#lista-horarios-especialidad').html('<div class="text-center py-3"><div class="spinner-border text-primary"></div><p class="text-muted mt-2">Buscando horarios...</p></div>');
        $('#contenedor-horarios-especialidad').removeClass('d-none');
        
        $.get('<?= baseUrl('/admin/turnos/available-slots-by-specialty') ?>', {
            especialidad_id: especialidadId,
            fecha_desde: '<?= date('Y-m-d') ?>'
        }, function(horarios) {
            if (horarios.error || horarios.length === 0) {
                $('#lista-horarios-especialidad').html('<p class="text-muted">No hay horarios disponibles en los próximos 7 días</p>');
            } else {
                let html = '';
                let fechaActual = null;
                
                horarios.forEach(slot => {
                    // Agrupar por fecha
                    if (slot.fecha !== fechaActual) {
                        if (fechaActual !== null) html += `</div></div>`;
                        fechaActual = slot.fecha;
                        html += `<div class="card"><div class="card-header"><strong>${slot.fecha_label}</strong></div><div class="card-body">`;
                    }
                    
                    html += `<button type="button" class="btn btn-outline-primary btn-sm m-1 slot-especialidad" 
                        data-fecha-hora="${slot.fecha_hora}" 
                        data-profesional-id="${slot.profesional_id}"
                        data-profesional-nombre="${slot.profesional_nombre}"
                        data-label="${slot.fecha_label} ${slot.hora}">
                        ${slot.hora} - ${slot.profesional_nombre}
                    </button>`;
                });
                html += `</div></div>`;
                
                $('#lista-horarios-especialidad').html(html);
            }
        });
    });

    // Seleccionar horario por especialidad
    $(document).on('click', '.slot-especialidad', function() {
        const fechaHora = $(this).data('fecha-hora');
        const profesionalId = $(this).data('profesional-id');
        const profesionalNombre = $(this).data('profesional-nombre');
        const label = $(this).data('label');
        
        $('#form_profesional_id').val(profesionalId);
        $('#form_fecha_hora').val(fechaHora + ':00');
        $('#form_sobreturno').val('0');
        $('#resumen-turno').text(`${profesionalNombre} - ${label}`);
        $('#box-sobreturno').addClass('d-none');
        
        $('#step-especialidad').addClass('d-none');
        $('#step-formulario').removeClass('d-none');
    });

    // ─────────────────────────────────────────────────────────────
    // FLUJO SOBRETURNO
    // ─────────────────────────────────────────────────────────────
    
    $('#btn-sobreturno').on('click', function() {
        $('#step-disponibilidad').addClass('d-none');
        $('#step-especialidad').addClass('d-none');
        $('#step-sobreturno').removeClass('d-none');
        $('#step-formulario').addClass('d-none');
    });

    $('#btn-cancelar-sobreturno').on('click', function() {
        $('#step-sobreturno').addClass('d-none');
        $('#step-disponibilidad').removeClass('d-none');
        $('#step-formulario').addClass('d-none');
    });

    $('#btn-confirmar-sobreturno').on('click', function() {
        const profesionalId = $('#sobreturno_profesional').val();
        const fechaHora = $('#sobreturno_fecha_hora').val();
        
        if (!profesionalId || !fechaHora) {
            alert('⚠️ Completá profesional y fecha/hora');
            return;
        }
        
        const profesionalNombre = $('#sobreturno_profesional option:selected').text();
        const fechaObj = new Date(fechaHora);
        
        $('#form_profesional_id').val(profesionalId);
        $('#form_fecha_hora').val(formatLocalDateTime(fechaObj));
        $('#form_sobreturno').val('1');
        $('#resumen-turno').text(`${profesionalNombre} - ${formatForDisplay(fechaObj)}`);
        
        $('#box-sobreturno').removeClass('d-none');
        $('#step-sobreturno').addClass('d-none');
        $('#step-formulario').removeClass('d-none');
    });

    // ─────────────────────────────────────────────────────────────
    // FLUJO NORMAL (por disponibilidad)
    // ─────────────────────────────────────────────────────────────

    $('#filtro_consultorio').on('change', function() {
        const consultorioId = $(this).val();
        $('#select_profesional option').each(function() {
            const profConsultorio = $(this).data('consultorio');
            $(this).toggle(!consultorioId || !profConsultorio || profConsultorio == consultorioId);
        });
        $('#select_profesional').val('').trigger('change');
        $('#contenedor-dias').addClass('d-none');
    });

    $('#select_profesional').on('change', function() {
        const profesionalId = $(this).val();
        const consultorioId = $(this).find('option:selected').data('consultorio');
        
        if (!profesionalId) {
            $('#contenedor-dias').addClass('d-none');
            return;
        }
        
        if (consultorioId) {
            $('#form_consultorio_id').val(consultorioId);
        }
        
        $.get('<?= baseUrl('/admin/turnos/available-slots') ?>', {
            profesional_id: profesionalId,
            fecha_desde: '<?= date('Y-m-d') ?>'
        }, function(dias) {
            if (dias.error || dias.length === 0) {
                $('#lista-dias').html('<p class="text-muted">No hay horarios disponibles en los próximos días</p>');
            } else {
                let html = '';
                dias.forEach(dia => {
                    html += `<div class="card"><div class="card-header"><strong>${dia.fecha_label}</strong></div><div class="card-body">`;
                    dia.horarios.forEach(hora => {
                        html += `<button type="button" class="btn btn-outline-primary btn-sm m-1 slot-horario" 
                            data-fecha="${dia.fecha}" data-hora="${hora}" data-label="${dia.fecha_label} ${hora}">
                            ${hora}
                        </button>`;
                    });
                    html += `</div></div>`;
                });
                $('#lista-dias').html(html);
            }
            $('#contenedor-dias').removeClass('d-none');
        });
    });

    $(document).on('click', '.slot-horario', function() {
        const fecha = $(this).data('fecha');
        const hora = $(this).data('hora');
        const label = $(this).data('label');
        const profesionalNombre = $('#select_profesional option:selected').text();
        
        $('#form_profesional_id').val($('#select_profesional').val());
        $('#form_fecha_hora').val(`${fecha} ${hora}:00`);
        $('#form_sobreturno').val('0');
        $('#resumen-turno').text(`${profesionalNombre} - ${label}`);
        $('#box-sobreturno').addClass('d-none');
        
        $('#step-disponibilidad').addClass('d-none');
        $('#step-formulario').removeClass('d-none');
    });

    // ─────────────────────────────────────────────────────────────
    // UTILIDADES GENERALES
    // ─────────────────────────────────────────────────────────────

    $('#btn-volver').on('click', function() {
        $('#step-formulario').addClass('d-none');
        $('#step-disponibilidad').removeClass('d-none');
    });

    $('#form-turno').on('submit', function(e) {
        const esSobreturno = $('#form_sobreturno').val() == '1';
        const checkSobreturno = $('#check_sobreturno');
        
        if (esSobreturno && !checkSobreturno.is(':checked')) {
            e.preventDefault();
            alert('⚠️ Debés confirmar "sobreturno" para continuar');
            checkSobreturno.focus();
        }
    });

    $('input[name="tipo_paciente"]').on('change', function() {
        const esExistente = $('#paciente_existente').is(':checked');
        $('#box_paciente_existente').toggleClass('d-none', !esExistente);
        $('#box_paciente_nuevo').toggleClass('d-none', esExistente);
        
        // Toggle required
        $('#paciente, #paciente_id').prop('required', esExistente);
        $('#box_paciente_nuevo input').prop('required', !esExistente);
    });

    // Autocomplete pacientes (debounce 300ms)
    let timeout;
    $('#paciente').on('input', function() {
        clearTimeout(timeout);
        const query = $(this).val();
        
        if (query.length < 2 || $('#paciente_nuevo').is(':checked')) { 
            $('#sugerenciasPacientes').hide(); 
            return; 
        }
        
        timeout = setTimeout(() => {
            $.get('<?= baseUrl('/admin/turnos/search-patient') ?>?q=' + encodeURIComponent(query), function(data) {
                const div = $('#sugerenciasPacientes');
                div.empty();
                
                if (data.length === 0) {
                    div.append('<span class="dropdown-item text-muted">No encontrado</span>');
                } else {
                    data.forEach(p => {
                        div.append(
                            $('<a class="dropdown-item" href="#">')
                                .text(p.apellido + ', ' + p.nombre + ' (DNI: ' + p.dni + ')')
                                .on('click', function(e) {
                                    e.preventDefault();
                                    $('#paciente').val(p.apellido + ', ' + p.nombre);
                                    $('#paciente_id').val(p.id);
                                    div.hide();
                                })
                        );
                    });
                }
                div.show();
            });
        }, 300);
    });
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#paciente, #sugerenciasPacientes').length) {
            $('#sugerenciasPacientes').hide();
        }
    });
    
    // Mostrar modo sobreturno si viene de URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('mode') === 'sobreturno') {
        $('#step-disponibilidad').addClass('d-none');
        $('#step-sobreturno').removeClass('d-none');
    }
});
</script>
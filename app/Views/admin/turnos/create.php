<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nuevo Turno</h3>
    </div>
    <div class="card-body">
        
        <!-- Paso 1: Selección de disponibilidad -->
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

        <!-- Paso 2: Formulario de confirmación (oculto hasta seleccionar horario) -->
        <div id="step-formulario" class="d-none">
            <form method="POST" action="<?= baseUrl('/admin/turnos/store') ?>" id="form-turno">
                <?= csrf_field() ?>
                
                <!-- Datos preseleccionados (readonly) -->
                <input type="hidden" name="profesional_id" id="form_profesional_id">
                <input type="hidden" name="fecha_hora" id="form_fecha_hora">
                <input type="hidden" name="consultorio_id" id="form_consultorio_id">
                
                <div class="alert alert-info mb-3">
                    <strong>Turno seleccionado:</strong><br>
                    <span id="resumen-turno"></span>
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

<!-- Select2 CSS (ya cargado en header, pero por si acaso) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

<script>
$(document).ready(function() {
    // Select2
    $('.form-select').select2({ theme: 'bootstrap-5' });

    // Cargar profesionales por consultorio
    $('#filtro_consultorio').on('change', function() {
        const consultorioId = $(this).val();
        $('#select_profesional option').each(function() {
            const profConsultorio = $(this).data('consultorio');
            $(this).toggle(!consultorioId || !profConsultorio || profConsultorio == consultorioId);
        });
        $('#select_profesional').val('').trigger('change');
        $('#contenedor-dias').addClass('d-none');
    });

    // Cargar días disponibles al seleccionar profesional
    $('#select_profesional').on('change', function() {
        const profesionalId = $(this).val();
        const consultorioId = $(this).find('option:selected').data('consultorio');
        
        if (!profesionalId) {
            $('#contenedor-dias').addClass('d-none');
            return;
        }
        
        // Pre-seleccionar consultorio si tiene default
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
                        const fechaHora = `${dia.fecha} ${hora}:00`;
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

    // Click en horario → mostrar formulario
    $(document).on('click', '.slot-horario', function() {
        const fecha = $(this).data('fecha');
        const hora = $(this).data('hora');
        const label = $(this).data('label');
        const profesionalNombre = $('#select_profesional option:selected').text();
        
        $('#form_profesional_id').val($('#select_profesional').val());
        $('#form_fecha_hora').val(`${fecha} ${hora}:00`);
        $('#resumen-turno').text(`${profesionalNombre} - ${label}`);
        
        $('#step-disponibilidad').addClass('d-none');
        $('#step-formulario').removeClass('d-none');
    });

    // Volver a selección
    $('#btn-volver').on('click', function() {
        $('#step-formulario').addClass('d-none');
        $('#step-disponibilidad').removeClass('d-none');
    });

    // Toggle paciente
    $('input[name="tipo_paciente"]').on('change', function() {
        if ($('#paciente_existente').is(':checked')) {
            $('#box_paciente_existente').removeClass('d-none');
            $('#box_paciente_nuevo').addClass('d-none');
            $('#paciente').attr('required', true);
            $('#paciente_id').attr('required', true);
            $('#box_paciente_nuevo input').prop('required', false);
        } else {
            $('#box_paciente_existente').addClass('d-none');
            $('#box_paciente_nuevo').removeClass('d-none');
            $('#paciente').attr('required', false);
            $('#paciente_id').attr('required', false);
            $('#box_paciente_nuevo input').prop('required', true);
        }
    });

    // Autocomplete pacientes (igual que antes)
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
});
</script>
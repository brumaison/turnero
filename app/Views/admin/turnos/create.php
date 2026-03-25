<div class="card">
    <div class="card-header">
        <h3 class="card-title">Crear Nuevo Turno</h3>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
                <div><i class="ti ti-alert-circle me-2"></i></div>
                <div><?= htmlspecialchars($_SESSION['error']) ?></div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            <?php unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div><i class="ti ti-check me-2"></i></div>
                <div><?= htmlspecialchars($_SESSION['success']) ?></div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            <?php unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <form action="<?= baseUrl('/admin/turnos/store') ?>" method="POST">
            <div class="row g-3">
                
                <!-- Toggle: Paciente Existente / Nuevo -->
                <div class="col-12">
                    <label class="form-label required">Tipo de Paciente</label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="tipo_paciente" id="paciente_existente" value="existente" checked>
                        <label class="btn btn-outline-primary" for="paciente_existente">
                            <i class="ti ti-search"></i> Buscar Existente
                        </label>
                        
                        <input type="radio" class="btn-check" name="tipo_paciente" id="paciente_nuevo" value="nuevo">
                        <label class="btn btn-outline-primary" for="paciente_nuevo">
                            <i class="ti ti-user-plus"></i> Crear Nuevo
                        </label>
                    </div>
                </div>

                <!-- Paciente Existente (autocomplete) -->
                <div class="col-md-4" id="box_paciente_existente">
                    <label class="form-label required">Paciente</label>
                    <input type="text" class="form-control" id="paciente" placeholder="DNI o nombre...">
                    <input type="hidden" name="paciente_id" id="paciente_id">
                    <div id="sugerenciasPacientes" class="dropdown-menu w-100" style="display:none;"></div>
                    <small class="text-muted">Buscar por DNI o apellido</small>
                </div>

                <!-- Paciente Nuevo (campos para crear) -->
                <div class="col-md-8" id="box_paciente_nuevo" style="display:none;">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label required">DNI *</label>
                            <input type="text" class="form-control" name="nuevo_paciente_dni" placeholder="12345678">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label required">Apellido y Nombre *</label>
                            <input type="text" class="form-control" name="nuevo_paciente_nombre" placeholder="González, Pedro">
                            <small class="text-muted">Formato: Apellido, Nombre</small>
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

                <!-- Profesional -->
                <div class="col-md-4">
                    <label class="form-label required">Profesional</label>
                    <select class="form-control" name="profesional_id" id="profesional_id" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach ($profesionales as $p): ?>
                        <option value="<?= $p['id'] ?>" data-consultorio="<?= $p['consultorio_default_id'] ?? '' ?>">
                            <?= htmlspecialchars($p['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fecha y Hora -->
                <div class="col-md-4">
                    <label class="form-label required">Fecha y Hora</label>
                    <input type="datetime-local" class="form-control" name="fecha_hora" id="fecha_hora" 
       value="<?= $fecha_seleccionada ? $fecha_seleccionada . 'T09:00' : '' ?>" 
       required min="<?= date('Y-m-d\TH:i') ?>">
                    <small class="text-muted">Solo fechas futuras</small>
                </div>

                <!-- Consultorio -->
                <div class="col-md-4">
                    <label class="form-label">Consultorio</label>
                    <select class="form-select" name="consultorio_id" id="consultorio_id">
                        <?php foreach ($consultorios as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Observaciones -->
                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" name="observaciones" rows="2" placeholder="Opcional"></textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="ti ti-check"></i> Guardar Turno
                </button>
                <a href="<?= baseUrl('/admin/turnos') ?>" class="btn btn-secondary">
                    <i class="ti ti-x"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle paciente existente / nuevo
$('input[name="tipo_paciente"]').on('change', function() {
    if ($('#paciente_existente').is(':checked')) {
        $('#box_paciente_existente').show();
        $('#box_paciente_nuevo').hide();
        $('#paciente').attr('required', true);
        $('#paciente_id').attr('required', true);
        $('#box_paciente_nuevo input').prop('required', false);
    } else {
        $('#box_paciente_existente').hide();
        $('#box_paciente_nuevo').show();
        $('#paciente').attr('required', false);
        $('#paciente_id').attr('required', false);
        $('#box_paciente_nuevo input').prop('required', true);
    }
});

// Autocomplete pacientes (solo si existe seleccionado)
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

// Cerrar sugerencias al hacer click fuera
$(document).on('click', function(e) {
    if (!$(e.target).closest('#paciente, #sugerenciasPacientes').length) {
        $('#sugerenciasPacientes').hide();
    }
});

// Pre-seleccionar consultorio según profesional
$('#profesional_id').on('change', function() {
    const consultorioDefault = $(this).find('option:selected').data('consultorio');
    if (consultorioDefault) {
        $('#consultorio_id').val(consultorioDefault);
    }
});

// Validar fecha futura (frontend)
$('#fecha_hora').on('change', function() {
    const selected = new Date($(this).val());
    const now = new Date();
    if (selected < now) {
        alert('La fecha debe ser futura');
        $(this).val('');
    }
});

$(document).ready(function() {
    // Inicializar Select2 en profesional y consultorio
    $('#profesional_id, #consultorio_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Seleccionar...',
        allowClear: true
    });
});
</script>
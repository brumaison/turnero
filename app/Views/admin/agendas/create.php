
<div class="card">
    <div class="card-header"><h3 class="card-title">Agregar Horario - <?= htmlspecialchars($profesional['nombre']) ?></h3></div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/profesionales/'.$profesional['id'].'/agenda/store') ?>">
            <div class="mb-3">
                <label class="form-label">Día</label>
                <select class="form-select" name="dia_semana" required>
                    <option value="1">Lunes</option>
                    <option value="2">Martes</option>
                    <option value="3">Miércoles</option>
                    <option value="4">Jueves</option>
                    <option value="5">Viernes</option>
                    <option value="6">Sábado</option>
                    <option value="7">Domingo</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora Inicio</label>
                    <input type="time" class="form-control" name="hora_inicio" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora Fin</label>
                    <input type="time" class="form-control" name="hora_fin" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Duración (minutos)</label>
                <input type="number" class="form-control" name="duracion_minutos" value="30" min="15" max="120">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?= baseUrl('/admin/profesionales/'.$profesional['id'].'/agenda') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
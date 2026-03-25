<?php $this->layout('admin/main', ['pageTitle' => $pageTitle, 'activePage' => $activePage]) ?>

<div class="card">
    <div class="card-header"><h3 class="card-title">Editar Horario</h3></div>
    <div class="card-body">
        <form method="POST" action="<?= baseUrl('/admin/profesionales/'.$profesional['id'].'/agenda/'.$agenda['id'].'/update') ?>">
            <div class="mb-3">
                <label class="form-label">Día</label>
                <select class="form-select" name="dia_semana" required>
                    <option value="1" <?= $agenda['dia_semana'] == 1 ? 'selected' : '' ?>>Lunes</option>
                    <option value="2" <?= $agenda['dia_semana'] == 2 ? 'selected' : '' ?>>Martes</option>
                    <option value="3" <?= $agenda['dia_semana'] == 3 ? 'selected' : '' ?>>Miércoles</option>
                    <option value="4" <?= $agenda['dia_semana'] == 4 ? 'selected' : '' ?>>Jueves</option>
                    <option value="5" <?= $agenda['dia_semana'] == 5 ? 'selected' : '' ?>>Viernes</option>
                    <option value="6" <?= $agenda['dia_semana'] == 6 ? 'selected' : '' ?>>Sábado</option>
                    <option value="7" <?= $agenda['dia_semana'] == 7 ? 'selected' : '' ?>>Domingo</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora Inicio</label>
                    <input type="time" class="form-control" name="hora_inicio" value="<?= $agenda['hora_inicio'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora Fin</label>
                    <input type="time" class="form-control" name="hora_fin" value="<?= $agenda['hora_fin'] ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Duración (minutos)</label>
                <input type="number" class="form-control" name="duracion_minutos" value="<?= $agenda['duracion_minutos'] ?? 30 ?>" min="15" max="120">
            </div>
            <div class="mb-3">
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" name="activo" value="1" <?= $agenda['activo'] ? 'checked' : '' ?>>
                    <span class="form-check-label">Activo</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="<?= baseUrl('/admin/profesionales/'.$profesional['id'].'/agenda') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
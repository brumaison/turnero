<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turnos - ByV</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; }
        .navbar { background: #007bff; color: white; padding: 15px 30px; display: flex; justify-content: space-between; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        h1 { margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .btn { padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-pendiente { background: #ffc107; }
        .badge-confirmado { background: #28a745; color: white; }
        .logout { color: white; text-decoration: none; }
    </style>
</head>
<body>
    <div class="navbar">
        <span>🏥 ByV Turnos</span>
        <span>
            <?= $_SESSION['user_email'] ?? '' ?> | 
            <a href="<?= baseUrl('/logout') ?>" class="logout">Cerrar Sesión</a>
        </span>
    </div>

    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1>📅 Turnos del Día</h1>
                <a href="#" class="btn btn-primary">+ Nuevo Turno</a>
            </div>

            <?php if (empty($turnos)): ?>
                <p style="color: #666;">No hay turnos programados para hoy.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>DNI</th>
                            <th>Profesional</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turnos as $turno): ?>
                        <tr>
                            <td><?= date('H:i', strtotime($turno['fecha_hora'])) ?></td>
                            <td><?= $turno['apellido'] ?>, <?= $turno['nombre'] ?></td>
                            <td><?= $turno['dni'] ?></td>
                            <td><?= $turno['profesional'] ?></td>
                            <td><span class="badge badge-pendiente">Pendiente</span></td>
                            <td>
                                <a href="#" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Cancelar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
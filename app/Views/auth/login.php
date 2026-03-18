<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - ByV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
</head>
<body class="border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <h1><?= config('logo') ?> <?= config('name') ?></h1>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-important alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form class="card card-md" action="<?= baseUrl('/login') ?>" method="post" autocomplete="off">
                <?= csrf_field() ?>
                
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                    
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="admin@byv.com" value="<?= old('email') ?>" autocomplete="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" autocomplete="current-password" required>
                    </div>
                    
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
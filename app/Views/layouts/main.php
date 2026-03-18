<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= config('name') ?></title>
    
    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        /* Ajustes personalizados si hacen falta */
    </style>
</head>
<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-overlap" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>                
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="<?= baseUrl('/turnos') ?>">
                        <span class="navbar-brand-image">
                            <strong><?= config('logo') ?> <?= config('short_name') ?></strong>
                        </span>
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link <?= ($activePage ?? '') == 'turnos' ? 'active' : '' ?>" href="<?= baseUrl('/turnos') ?>">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-calendar"></i></span>
                                <span class="nav-link-title">Turnos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="nav-link-icon"><i class="ti ti-users"></i></span>
                                <span class="nav-link-title">Pacientes</span>
                            </a>
                        </li>
                        <!-- Agrega más menú según rol -->
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <div class="page-wrapper">
            <!-- Navbar Superior -->
            <header class="navbar navbar-expand-md navbar-overlap d-print-none">
                    <div class="container-fluid">
                        <!-- Toggle eliminado - ya está en el sidebar -->
                        
                        <h1 class="navbar-brand d-none d-md-block">
                            <a href="<?= baseUrl('/turnos') ?>" class="text-reset text-decoration-none">
                                <strong><?= config('logo') ?> <?= config('short_name') ?></strong>
                            </a>
                        </h1>

                    <!-- User Menu - ALINEADO A LA DERECHA -->
                    <div class="navbar-nav flex-row ms-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm" style="background-color: #007bff; color: white;">
                                    <?= strtoupper(substr($_SESSION['user_email'] ?? 'U', 0, 1)) ?>
                                </span>
                                <div class="d-none d-xl-block ps-2">
                                    <div><?= htmlspecialchars($_SESSION['user_email'] ?? 'Usuario') ?></div>
                                    <div class="mt-1 small text-muted"><?= htmlspecialchars($_SESSION['user_rol'] ?? '') ?></div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="<?= baseUrl('/logout') ?>" class="dropdown-item">
                                    <i class="ti ti-logout me-2"></i>Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h2 class="page-title"><?= $pageTitle ?? 'Dashboard' ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <!-- AQUÍ VA EL CONTENIDO DE CADA VISTA -->
                    <?= $content ?? '' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
</body>
</html>
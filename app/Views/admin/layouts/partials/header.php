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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
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
                    <a href="<?= baseUrl('/admin/turnos') ?>">
                        <span class="navbar-brand-image">
                            <strong><?= config('logo') ?> <?= config('short_name') ?></strong>
                        </span>
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <!-- Turnos -->
                        <li class="nav-item dropdown <?= $activePage === 'turnos' ? 'show' : '' ?>">
                            <a class="nav-link dropdown-toggle <?= in_array($activePage, ['turnos']) ? 'active' : '' ?>" 
                               href="#" data-bs-toggle="dropdown">
                                <span class="nav-link-icon"><i class="ti ti-calendar"></i></span>
                                <span class="nav-link-title">Turnos</span>
                            </a>
                            <div class="dropdown-menu <?= $activePage === 'turnos' ? 'show' : '' ?>">
                                <a class="dropdown-item <?= $activeSubPage === 'index' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/turnos') ?>">Lista</a>
                                <a class="dropdown-item <?= $activeSubPage === 'calendar' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/turnos/calendar') ?>">Calendario</a>
                                <a class="dropdown-item <?= $activeSubPage === 'create' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/turnos/create') ?>">Nuevo Turno</a>
                            </div>
                        </li>

                        <!-- Profesionales -->
                        <li class="nav-item dropdown <?= $activePage === 'profesionales' ? 'show' : '' ?>">
                            <a class="nav-link dropdown-toggle <?= in_array($activePage, ['profesionales']) ? 'active' : '' ?>" 
                               href="#" data-bs-toggle="dropdown">
                                <span class="nav-link-icon"><i class="ti ti-user-circle"></i></span>
                                <span class="nav-link-title">Profesionales</span>
                            </a>
                            <div class="dropdown-menu <?= $activePage === 'profesionales' ? 'show' : '' ?>">
                                <a class="dropdown-item <?= $activeSubPage === 'index' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/profesionales') ?>">Lista</a>
                                <a class="dropdown-item <?= $activeSubPage === 'create' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/profesionales/create') ?>">Nuevo</a>
                            </div>
                        </li>

                        <!-- Especialidades -->
                        <li class="nav-item dropdown <?= $activePage === 'especialidades' ? 'show' : '' ?>">
                            <a class="nav-link dropdown-toggle <?= in_array($activePage, ['especialidades']) ? 'active' : '' ?>" 
                               href="#" data-bs-toggle="dropdown">
                                <span class="nav-link-icon"><i class="ti ti-stethoscope"></i></span>
                                <span class="nav-link-title">Especialidades</span>
                            </a>
                            <div class="dropdown-menu <?= $activePage === 'especialidades' ? 'show' : '' ?>">
                                <a class="dropdown-item <?= $activeSubPage === 'index' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/especialidades') ?>">Lista</a>
                                <a class="dropdown-item <?= $activeSubPage === 'create' ? 'active' : '' ?>" 
                                   href="<?= baseUrl('/admin/especialidades/create') ?>">Nueva</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Contenido Principal -->
        <div class="page-wrapper">
            <!-- Navbar Superior -->
            <header class="navbar navbar-expand-md navbar-overlap d-print-none">
                <div class="container-fluid">
                    <h1 class="navbar-brand d-none d-md-block">
                        <a href="<?= baseUrl('/admin/turnos') ?>" class="text-reset text-decoration-none">
                            <strong><?= config('logo') ?> <?= config('short_name') ?></strong>
                        </a>
                    </h1>
                    <!-- User Menu -->
                    <div class="navbar-nav flex-row ms-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm" style="background-color:#007bff;color:white;">
                                    <?= strtoupper(substr($_SESSION['user_email'] ?? 'U', 0, 1)) ?>
                                </span>
                                <div class="d-none d-xl-block ps-2">
                                    <div><?= htmlspecialchars($_SESSION['user_email'] ?? 'Usuario') ?></div>
                                    <div class="mt-1 small text-muted"><?= htmlspecialchars($_SESSION['user_role_slug'] ?? '') ?></div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="<?= baseUrl('/admin/logout') ?>" class="dropdown-item">
                                    <i class="ti ti-logout me-2"></i>Cerrar Sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                        </header>

            <!-- Flash Messages -->
            <?php
            $flash_types = [
                'success' => ['class' => 'alert-success', 'icon' => 'ti-check'],
                'error'   => ['class' => 'alert-danger', 'icon' => 'ti-alert-circle'],
                'warning' => ['class' => 'alert-warning', 'icon' => 'ti-alert-triangle'],
            ];
            foreach ($flash_types as $type => $cfg) {
                $method = 'get' . ucfirst($type);
                if ($message = \App\Core\Flash::$method()) {
                    ?>
                    <div class="container-fluid mt-3">
                        <div class="alert <?= $cfg['class'] ?> alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div><i class="ti <?= $cfg['icon'] ?> me-2"></i><?= htmlspecialchars($message) ?></div>
                                <a class="ms-auto" data-bs-dismiss="alert"></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

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
                    <!-- CONTENIDO DE LA VISTA -->
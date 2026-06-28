<?php
$current = $_SERVER['REQUEST_URI'];

$rol = $_SESSION['user']['rol'] ?? 0;

$nombreUsuario =
    ($_SESSION['user']['nombres'] ?? '') . ' ' .
    ($_SESSION['user']['apellidos'] ?? '');

?>

<div class="sidebar" id="sidebar">

    <div class="sidebar-header" id="toggleBtn">

        <img src="/Edutech/public/img/logo.png" alt="Logo">

        <span class="logo-text">EduTech</span>

    </div>

    <div class="sidebar-menu">

        <?php if ($rol == 1): ?>
            <div class="menu-section" data-tooltip="General">
                GENERAL
            </div>

            <a href="/Edutech/admin"
                data-tooltip="Dashboard"
                class="<?= str_contains($current, '/admin') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <div class="menu-section" data-tooltip="Gestión">
                GESTIÓN
            </div>

            <a href="/Edutech/admin/usuarios"
                data-tooltip="Usuarios"
                class="<?= str_contains($current, '/usuarios') ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i>
                <span class="menu-text">Usuarios</span>
            </a>

            <a href="/Edutech/admin/cursos"
                data-tooltip="Cursos"
                class="<?= str_contains($current, '/cursos') ? 'active' : '' ?>">
                <i class="fa-solid fa-book"></i>
                <span class="menu-text">Cursos</span>
            </a>

            <div class="menu-section" data-tooltip="Servicios">
                SERVICIOS
            </div>

            <a href="#"
                data-tooltip="Edupay"
                class="<?= str_contains($current, '/edupay') ? 'active' : '' ?>">
                <i class="fa-solid fa-building-columns"></i>
                <span class="menu-text">EduPay</span>
            </a>

            <a href="#"
                data-tooltip="Biblioteca"
                class="<?= str_contains($current, '/biblioteca') ? 'active' : '' ?>">
                <i class="fa-solid fa-book-open"></i>
                <span class="menu-text">Biblioteca</span>
            </a>

            <div class="menu-section" data-tooltip="Análisis">
                ANÁLISIS
            </div>

            <a href="/Edutech/admin/certificados"
                data-tooltip="Certificados"
                class="<?= $module == 'certificados' ? 'active' : '' ?>">

                <i class="fa-solid fa-certificate"></i>

                <span class="menu-text">
                        Certificados
                </span>
            </a>

            <a href="#"
                data-tooltip="Reportes"
                class="<?= str_contains($current, '/reportes') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-column"></i>
                <span class="menu-text">Reportes</span>
            </a>
        <?php endif; ?>

        <?php if ($rol == 2): ?>
            <a href="/Edutech/asesor">
                <i class="fa-solid fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="/Edutech/cursos">
                <i class="fa-solid fa-book"></i>
                <span class="menu-text">Mis Cursos</span>
            </a>
        <?php endif; ?>

        <?php if ($rol == 3): ?>
            <a href="/Edutech/alumno">
                <i class="fa-solid fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="/Edutech/mis-cursos">
                <i class="fa-solid fa-book"></i>
                <span class="menu-text">Mis Cursos</span>
            </a>
        <?php endif; ?>
    </div>

    <div class="user-card">

        <?php
            $nombre = $_SESSION['user']['nombres'] ?? 'U';
            $apellidos = $_SESSION['user']['apellidos'] ?? '';

            $iniciales =
                strtoupper(substr($nombre, 0, 1)) .
                strtoupper(substr($apellidos, 0, 1));
            ?>

            <div class="user-avatar">
                <?= $iniciales ?>
            </div>

        <div class="user-info">

            <span class="user-name">
                <?= htmlspecialchars($nombreUsuario) ?>
            </span>

            <span class="user-role">

                <?php
                    if ($rol == 1) echo 'Administrador';
                    elseif ($rol == 2) echo 'Asesor';
                    elseif ($rol == 3) echo 'Alumno';
                ?>

            </span>

            <span class="user-status">
                <span class="status-dot"></span>
                En línea
            </span>

        </div>

        <a href="/Edutech/logout" class="logout-icon">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>

    </div>

</div>

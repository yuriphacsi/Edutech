<?php
$current = $_SERVER['REQUEST_URI'];

// Verificación flexible para asegurar que capture el rol correctamente
$rol = $_SESSION['user']['rol'] ?? $_SESSION['user']['role_id'] ?? $_SESSION['user']['id_rol'] ?? 0;

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
                class="<?= str_contains($current, '/admin') && !str_contains($current, '/usuarios') && !str_contains($current, '/cursos') && !str_contains($current, '/certificados') ? 'active' : '' ?>">
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
                <i class="fa-solid fa-chalkboard-user"></i>
                <span class="menu-text">Cursos</span>
            </a>

            <div class="menu-section" data-tooltip="Servicios">
                SERVICIOS
            </div>

            <a href="/Edutech/alumno/pagos"
                data-tooltip="Edupay"
                class="<?= str_contains($current, '/pagos') ? 'active' : '' ?>">
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
                class="<?= isset($module) && $module == 'certificados' ? 'active' : '' ?>">

                <i class="fa-solid fa-graduation-cap"></i>

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

            <div class="menu-section" data-tooltip="General">
                GENERAL
            </div>

            <a href="/Edutech/asesor"
                data-tooltip="Dashboard"
                class="<?= str_contains($current, '/asesor') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <div class="menu-section" data-tooltip="Gestión">
                GESTIÓN
            </div>

            <a href="/Edutech/cursos"
                data-tooltip="Mis Cursos"
                class="<?= str_contains($current, '/cursos') ? 'active' : '' ?>">
                <i class="fa-solid fa-chalkboard-user"></i>
                <span class="menu-text">Mis Cursos</span>
            </a>

            <a href="#"
                data-tooltip="Asistencias"
                class="">
                <i class="fa-solid fa-user-check"></i>
                <span class="menu-text">Asistencias</span>
            </a>

            <a href="#"
                data-tooltip="Notas"
                class="">
                <i class="fa-solid fa-clipboard-list"></i>
                <span class="menu-text">Notas</span>
            </a>

            <div class="menu-section" data-tooltip="Análisis">
                ANÁLISIS
            </div>

            <a href="#"
                data-tooltip="Reportes"
                class="">
                <i class="fa-solid fa-chart-column"></i>
                <span class="menu-text">Reportes</span>
            </a>

        <?php endif; ?>

        <?php if ($rol == 3): ?>

            <div class="menu-section" data-tooltip="General">
                GENERAL
            </div>

            <a href="/Edutech/alumno"
                data-tooltip="Dashboard"
                class="<?= str_contains($current, '/alumno') && !str_contains($current, '/pagos') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <div class="menu-section" data-tooltip="Académico">
                ACADÉMICO
            </div>

            <a href="/Edutech/mis-cursos"
                data-tooltip="Mis Cursos"
                class="<?= str_contains($current, '/mis-cursos') ? 'active' : '' ?>">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="menu-text">Mis Cursos</span>
            </a>

            <a href="/Edutech/alumno/pagos"
                data-tooltip="Pagos"
                class="<?= str_contains($current, '/pagos') ? 'active' : '' ?>">
                <i class="fa-solid fa-credit-card"></i>
                <span class="menu-text">Mis Pagos</span>
            </a>

            <a href="#"
                data-tooltip="Certificados"
                class="">
                <i class="fa-solid fa-certificate"></i>
                <span class="menu-text">Mis Certificados</span>
            </a>

            <div class="menu-section" data-tooltip="Seguimiento">
                SEGUIMIENTO
            </div>

            <a href="/Edutech/mis-notes"
                data-tooltip="Notas"
                class="<?= str_contains($current, '/mis-notas') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-column"></i>
                <span class="menu-text">Mis Notas</span>
            </a>

            <a href="/Edutech/mis-asistencia"
                data-tooltip="Asistencia"
                class="<?= str_contains($current, '/mis-asistencia') ? 'active' : '' ?>">
                <i class="fa-solid fa-user-check"></i>
                <span class="menu-text">Mi Asistencia</span>
            </a>

            <a href="#"
                data-tooltip="Biblioteca"
                class="">
                <i class="fa-solid fa-book-open"></i>
                <span class="menu-text">Biblioteca</span>
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

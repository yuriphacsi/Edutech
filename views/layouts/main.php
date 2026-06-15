<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduTech</title>

    <link rel="stylesheet" href="/Edutech/public/css/app.css">
    <link rel="icon" href="/Edutech/public/img/logo.png">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<?php $rol = $_SESSION['user']['rol'] ?? 0; ?>

<div class="sidebar" id="sidebar">

    <div class="sidebar-header" id="toggleBtn">

        <img src="/Edutech/public/img/logo.png" alt="Logo">

        <span class="logo-text">EduTech</span>

    </div>

    <div class="sidebar-menu">

        <?php if ($rol == 1): ?>
            <a href="/Edutech/admin">
                <i class="fa-solid fa-chart-line"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="/Edutech/usuarios">
                <i class="fa-solid fa-users"></i>
                <span class="menu-text">Usuarios</span>
            </a>

            <a href="/Edutech/cursos">
                <i class="fa-solid fa-book"></i>
                <span class="menu-text">Cursos</span>
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

    <div class="sidebar-footer">
        <a href="/Edutech/logout" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="menu-text">Cerrar Sesión</span>
        </a>
    </div>

</div>

<div class="main-content" id="main-content">
    <?= $content ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('main-content');

    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
    }

    // click en logo
    toggleBtn.addEventListener('click', toggleSidebar);

});
</script>

</body>
</html>
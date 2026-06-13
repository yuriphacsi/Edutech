<div class="sidebar" id="sidebar">

    <div class="sidebar-header">

        <button id="toggleBtn">
            <i class="fas fa-bars"></i>
        </button>

        <span class="logo-text">EduTech</span>

    </div>

    <div class="sidebar-menu">

        <a href="/Edutech/admin">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="/Edutech/usuarios">
            <i class="fas fa-users"></i>
            <span>Usuarios</span>
        </a>

        <a href="/Edutech/cursos">
            <i class="fas fa-book"></i>
            <span>Cursos</span>
        </a>

        <a href="#">
            <i class="fas fa-calendar"></i>
            <span>Reservas</span>
        </a>

    </div>

    <div class="sidebar-footer">

        <a href="/Edutech/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Salir</span>
        </a>

    </div>

</div>

<div class="main-content" id="main-content">
    <?= $content ?>
</div>
<div class="dashboard-header">

    <div>
        <h1>Dashboard</h1>
        <p>
            Bienvenido al panel administrativo de EduTech
        </p>
    </div>

</div>

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>

        <div>
            <span class="stat-label">Usuarios</span>
            <h2><?= $totalUsuarios ?? 0 ?></h2>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-icon">
            <i class="fa-solid fa-book"></i>
        </div>

        <div>
            <span class="stat-label">Cursos</span>
            <h2><?= $totalCursos ?? 0 ?></h2>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-icon">
            <i class="fa-solid fa-user-graduate"></i>
        </div>

        <div>
            <span class="stat-label">Tutorías</span>
            <h2>0</h2>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-icon">
            <i class="fa-solid fa-building-columns"></i>
        </div>

        <div>
            <span class="stat-label">EduPay</span>
            <h2>S/ 0</h2>
        </div>

    </div>

</div>

<div class="dashboard-row">
    <div class="chart-card">

        <h3>
            <i class="fa-solid fa-chart-line"></i>
            Crecimiento de Usuarios
        </h3>

        <canvas id="usersChart"></canvas>

    </div>

</div>

<div class="dashboard-grid">

    <div class="activity-card">

        <h3>
            <i class="fa-solid fa-clock-rotate-left"></i>
            Actividad reciente
        </h3>

        <ul class="activity-list">

            <li>
                <span class="activity-dot"></span>
                Nuevo usuario registrado
            </li>

            <li>
                <span class="activity-dot"></span>
                Curso agregado al sistema
            </li>

            <li>
                <span class="activity-dot"></span>
                Actualización de permisos
            </li>

            <li>
                <span class="activity-dot"></span>
                Inicio de sesión administrador
            </li>

        </ul>

    </div>

    <div class="system-card">

        <h3>
            <i class="fa-solid fa-server"></i>
            Estado del Sistema
        </h3>

        <div class="system-item">
            <span>Base de Datos</span>
            <span class="status success">Conectada</span>
        </div>

        <div class="system-item">
            <span>Servidor</span>
            <span class="status success">Operativo</span>
        </div>

        <div class="system-item">
            <span>Autenticación</span>
            <span class="status success">Activa</span>
        </div>

        <div class="system-item">
            <span>EduPay</span>
            <span class="status pending">Próximamente</span>
        </div>

    </div>

    <div class="quick-card">

        <h3>
            <i class="fa-solid fa-bolt"></i>
            Accesos Rápidos
        </h3>

        <div class="quick-links">

            <a href="/Edutech/usuarios">
                <i class="fa-solid fa-users"></i>
                Usuarios
            </a>

            <a href="/Edutech/cursos">
                <i class="fa-solid fa-book"></i>
                Cursos
            </a>

            <a href="#">
                <i class="fa-solid fa-user-graduate"></i>
                Tutorías
            </a>

            <a href="#">
                <i class="fa-solid fa-building-columns"></i>
                EduPay
            </a>

        </div>

    </div>
</div>

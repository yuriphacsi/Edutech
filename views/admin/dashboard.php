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
            <i class="fa-solid fa-user-check"></i>
        </div>

        <div>
            <span class="stat-label">Activos</span>
            <h2><?= $usuariosActivos ?? 0 ?></h2>
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-icon">
            <i class="fa-solid fa-user-xmark"></i>
        </div>

        <div>
            <span class="stat-label">Inactivos</span>
            <h2><?= $usuariosInactivos ?? 0 ?></h2>
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

</div>

<div class="dashboard-grid">

    <div class="activity-card">

        <h3>Últimos usuarios</h3>

        <ul class="activity-list">

            <?php foreach ($ultimosUsuarios as $u): ?>

                <li>
                    <span class="activity-dot"></span>

                    <div class="activity-content">

                        <strong>
                        <?= htmlspecialchars($u['nombre_completo'] ?? 'Usuario') ?>
                    </strong>

                        <span class="activity-time">
                            se registró <?= timeAgo($u['created_at']) ?>
                        </span>

                    </div>
                </li>

            <?php endforeach; ?>

        </ul>

    </div>

    <div class="activity-card">

        <h3>
            <i class="fa-solid fa-right-to-bracket"></i>
            Últimos accesos
        </h3>

        <ul class="activity-list">

            <?php foreach ($ultimosAccesos as $u): ?>

                <li>

                    <span class="activity-dot"></span>

                    <div class="activity-content">

                        <strong>
                            <?= htmlspecialchars($u['nombre_completo']) ?>
                        </strong>

                        <span class="activity-time">
                            inició sesión <?= timeAgo($u['last_login']) ?>
                        </span>

                    </div>

                </li>

            <?php endforeach; ?>

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
</div>

<div class="dashboard-row">
    <div class="chart-card">

        <h3>
            <i class="fa-solid fa-chart-line"></i>
            Crecimiento de Usuarios
        </h3>

        <canvas id="usersChart"></canvas>

    </div>

    <script>
        window.usuariosUltimos12Meses = <?= json_encode($usuariosUltimos12Meses) ?>;
    </script>

</div>

<script>
    window.usuariosPorMes = <?= json_encode($usuariosPorMes ?? []) ?>;
</script>
<script>
    window.usuariosUltimos12Meses = <?= json_encode($usuariosUltimos12Meses ?? []) ?>;
</script>

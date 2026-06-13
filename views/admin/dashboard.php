<h1>📊 Dashboard Admin</h1>

<p class="subtitle">
    Bienvenido al panel de administración de EduTech
</p>

<div class="grid">

    <div class="card">
        <h2>👥 Usuarios</h2>
        <p>Gestión de estudiantes, asesores y administradores</p>
        <span class="stat"><?= $totalUsuarios ?? 0 ?></span>
    </div>

    <div class="card">
        <h2>📚 Cursos</h2>
        <p>Administración de cursos</p>
        <span class="stat"><?= $totalCursos ?? 0 ?></span>
    </div>

    <div class="card">
        <h2>📅 Reservas</h2>
        <p>Control de inscripciones</p>
        <span class="stat">0</span>
    </div>

    <div class="card">
        <h2>⚙️ Sistema</h2>
        <p>Estado general del sistema</p>
        <span class="stat">Activo</span>
    </div>

</div>
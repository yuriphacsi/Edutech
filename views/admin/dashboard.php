<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Admin - EduTech</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    background: radial-gradient(circle at top, #0f172a, #020617);
    color: white;
}

/* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.navbar .logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    color: #60a5fa;
}

.navbar .logo img {
    width: 30px;
}

.navbar a {
    color: #cbd5e1;
    text-decoration: none;
    margin-left: 20px;
    transition: 0.3s;
}

.navbar a:hover {
    color: white;
}

/* CONTENT */
.container {
    padding: 100px 5px 40px;
}

h1 {
    font-size: 32px;
}

.subtitle {
    color: #94a3b8;
    margin-bottom: 30px;
}

/* CARDS */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

.card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    padding: 20px;
    border-radius: 16px;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
    background: rgba(255,255,255,0.08);
}

.card h2 {
    font-size: 20px;
    margin-bottom: 10px;
}

.card p {
    color: #94a3b8;
    font-size: 14px;
}

.stat {
    margin-top: 15px;
    display: inline-block;
    color: #60a5fa;
    font-weight: bold;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <div class="logo">
        <img src="/Edutech/public/img/logo.png" alt="logo">
        EduTech Admin
    </div>

    <div>
        <a href="/Edutech/admin">Dashboard</a>
        <a href="/Edutech/usuarios">Usuarios</a>
        <a href="/Edutech/cursos">Cursos</a>
        <a href="/Edutech/logout">Salir</a>
    </div>

</div>

<!-- CONTENT -->
<div class="container">

    <h1>📊 Dashboard Admin</h1>
    <p class="subtitle">Bienvenido al panel de administración de EduTech</p>

    <div class="grid">

        <div class="card">
            <h2>👥 Usuarios</h2>
            <p>Gestión de estudiantes, asesores y admins</p>
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
            <span class="stat">--</span>
        </div>

        <div class="card">
            <h2>⚙️ Sistema</h2>
            <p>Estado general del sistema</p>
            <span class="stat">Activo</span>
        </div>

    </div>

</div>

</body>
</html>
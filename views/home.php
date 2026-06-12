<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>EduTech - Plataforma Educativa</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

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
        overflow-x: hidden;
    }

    /* NAVBAR */
    .nav {
        display: flex;
        justify-content: space-between;
        padding: 20px 60px;
        position: fixed;
        width: 100%;
        top: 0;
        backdrop-filter: blur(10px);
        background: rgba(15, 23, 42, 0.6);
        z-index: 100;
    }

    .logo {
        font-weight: 700;
        font-size: 20px;
        color: #60a5fa;
    }

    .nav a {
        color: #cbd5e1;
        margin-left: 20px;
        text-decoration: none;
        transition: 0.3s;
    }

    .nav a:hover {
        color: white;
    }

    /* HERO */
    .hero {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 0 20px;
    }

    .hero h1 {
        font-size: 70px;
        font-weight: 700;
        background: linear-gradient(90deg, #60a5fa, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeUp 1s ease;
    }

    .hero p {
        margin-top: 20px;
        max-width: 700px;
        color: #94a3b8;
        font-size: 18px;
        animation: fadeUp 1.3s ease;
    }

    .btn {
        margin-top: 30px;
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        color: white;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* STATS */
    .stats {
        display: flex;
        justify-content: center;
        gap: 40px;
        padding: 60px 20px;
        flex-wrap: wrap;
    }

    .stat {
        background: rgba(255,255,255,0.05);
        padding: 20px 30px;
        border-radius: 16px;
        text-align: center;
        min-width: 150px;
        backdrop-filter: blur(10px);
        transition: 0.3s;
    }

    .stat:hover {
        transform: translateY(-5px);
    }

    .stat h2 {
        font-size: 28px;
        color: #60a5fa;
    }

    /* SECTIONS */
    section {
        padding: 100px 20px;
        text-align: center;
    }

    h2 {
        font-size: 40px;
        margin-bottom: 20px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        max-width: 1000px;
        margin: auto;
    }

    .card {
        background: rgba(255,255,255,0.05);
        padding: 25px;
        border-radius: 16px;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.08);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 20px;
        color: #60a5fa;
    }

    .logo img {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }

    .card:hover {
        transform: translateY(-8px);
        background: rgba(255,255,255,0.08);
    }

    footer {
        text-align: center;
        padding: 40px;
        color: #64748b;
    }

    /* ANIMATIONS */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="nav">
    <div class="logo">
        <img src="/Edutech/public/img/logo.png" alt="EduTech Logo">
        <span>EduTech</span>
    </div>
    <div>
        <a href="#features">Características</a>
        <a href="#vision">Visión</a>
        <a href="/Edutech/login">Login</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Aprende. Gestiona. Crece.</h1>
    <p>
        Plataforma educativa moderna que conecta estudiantes, asesores y administradores
        en un ecosistema digital inteligente.
    </p>

    <a href="/Edutech/login" class="btn btn-primary">Comenzar Ahora</a>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat">
        <h2>100+</h2>
        <p>Usuarios</p>
    </div>
    <div class="stat">
        <h2>20+</h2>
        <p>Cursos</p>
    </div>
    <div class="stat">
        <h2>3</h2>
        <p>Roles</p>
    </div>
</div>

<!-- VISION -->
<section id="vision">
    <h2>🌍 Visión</h2>
    <p style="max-width:700px;margin:auto;color:#94a3b8;">
        Ser una plataforma educativa líder en innovación digital, integrando tecnología
        y aprendizaje personalizado para transformar la educación.
    </p>
</section>

<!-- FEATURES -->
<section id="features">
    <h2>⚡ Características</h2>

    <div class="grid">
        <div class="card">🔐 Sistema de Roles</div>
        <div class="card">📚 Gestión de Cursos</div>
        <div class="card">👨‍🏫 Panel de Asesores</div>
        <div class="card">👨‍🎓 Panel de Estudiantes</div>
        <div class="card">⚙️ MVC Propio</div>
        <div class="card">🚀 Escalable</div>
    </div>
</section>

<footer>
    © <?= date('Y') ?> EduTech - Plataforma Educativa
</footer>

</body>
</html>
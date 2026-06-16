<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduTech</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/Edutech/public/css/public.css?v=<?= time() ?>">
    <link rel="icon" href="/Edutech/public/img/logo.png">
</head>

<body>

    <!-- NAVBAR -->
    <header class="public-nav">

        <div class="public-logo">
            <img src="/Edutech/public/img/logo.png" alt="EduTech">
            <span>EduTech</span>
        </div>

        <nav class="public-nav-links">
            <a href="#features">Características</a>
            <a href="#mission-vision" onclick="showMV('mision')">Misión y Visión</a>
            <a class="login" href="/Edutech/login">Login</a>
        </nav>

    </header>

    <!-- CONTENIDO -->
    <main class="public-main">
        <?= $content ?>
    </main>

    <!-- FOOTER -->
    <footer class="public-footer">
        © <?= date('Y') ?> EduTech - Plataforma Educativa
    </footer>

</body>
</html>
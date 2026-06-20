<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduTech</title>

    <link rel="stylesheet" href="/Edutech/public/css/app.css">
    <link rel="stylesheet" href="/Edutech/public/css/modules/dashboard.css">
    <link rel="stylesheet" href="/Edutech/public/css/modules/usuarios.css">
    <link rel="icon" href="/Edutech/public/img/logo.png">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <div class="main-content" id="main-content">

        <?php require_once __DIR__ . '/breadcrumbs.php'; ?>

        <?= $content ?>

    </div>

    <script src="/Edutech/public/js/sidebar.js"></script>
    <script src="/Edutech/public/js/notifications.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/Edutech/public/js/dashboard.js"></script>
</body>
</html>
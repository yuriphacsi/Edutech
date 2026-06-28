<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduTech</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="/Edutech/public/css/app.css">
    <link rel="stylesheet" href="/Edutech/public/css/components.css">

    <?php
        /**
         * Módulo actual (dashboard, usuarios, cursos, etc)
         * Si no existe, no rompe nada
         */
        $module = $module ?? null;
    ?>

    <!-- CSS DINÁMICO POR MÓDULO -->
    <?php if ($module): ?>
        <link rel="stylesheet" href="/Edutech/public/css/modules/<?= $module ?>.css">
    <?php endif; ?>

    <?php if (!empty($moduleCss)): ?>
        <?php foreach ($moduleCss as $css): ?>
            <link rel="stylesheet" href="/Edutech/public/css/modules/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- ICONOS -->
    <link rel="icon" href="/Edutech/public/img/logo.png">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <!-- SIDEBAR -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <!-- CONTENIDO -->
    <div class="main-content" id="main-content">

        <!-- TOPBAR / BREADCRUMBS -->
        <?php require_once __DIR__ . '/breadcrumbs.php'; ?>

        <!-- VISTA ACTUAL -->
        <?= $content ?>

    </div>

    <!-- JS GLOBAL -->
    <script src="/Edutech/public/js/sidebar.js"></script>
    <script src="/Edutech/public/js/notifications.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JS POR MÓDULO -->
    <?php if ($module): ?>
        <script src="/Edutech/public/js/modules/<?= $module ?>.js"></script>
    <?php endif; ?>

</body>
</html>
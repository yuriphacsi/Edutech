<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduTech</title>
    <link rel="stylesheet" href="/Edutech/public/css/app.css">
    
    <link rel="icon" href="/Edutech/public/img/logo.png">
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside>
        <?php include __DIR__ . '/sidebar.php'; ?>
    </aside>

    <!-- CONTENIDO -->
    <main>
        <?= $content ?>
    </main>

</div>

</body>
</html>
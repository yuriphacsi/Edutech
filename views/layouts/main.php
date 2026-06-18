<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduTech</title>

    <link rel="stylesheet" href="/Edutech/public/css/app.css">
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('main-content');

        // Restaurar estado guardado
        const isCollapsed =
            localStorage.getItem('sidebarCollapsed');

        if (isCollapsed === 'true') {

            sidebar.classList.add('collapsed');
            content.classList.add('expanded');

        }

        function toggleSidebar() {

            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');

            localStorage.setItem(
                'sidebarCollapsed',
                sidebar.classList.contains('collapsed')
            );
        }

        toggleBtn.addEventListener('click', toggleSidebar);

    });
    </script>

</body>
</html>
<?php

$current = $_SERVER['REQUEST_URI'];

$breadcrumbs = [
    '/admin'    => ['Dashboard'],
    '/usuarios' => ['Dashboard', 'Usuarios'],
    '/cursos'   => ['Dashboard', 'Cursos'],
];

$items = ['Dashboard'];

foreach ($breadcrumbs as $route => $trail) {
    if (str_contains($current, $route)) {
        $items = $trail;
        break;
    }
}
?>

<div class="topbar">

<div class="topbar-left">

    <div class="breadcrumbs">

        <?php foreach ($items as $index => $item): ?>

            <span><?= $item ?></span>

            <?php if ($index < count($items) - 1): ?>
                <span class="separator">›</span>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>

</div>

<div class="topbar-right">

    <div class="search-box">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="text"
            placeholder="Buscar..."
        >

    </div>

    <div class="notification-wrapper">

        <button id="notificationBtn" class="notification-btn">

            <i class="fa-solid fa-bell"></i>

            <span class="notification-count">3</span>

        </button>

        <div id="notificationPanel" class="notification-panel">

            <div class="notification-header">
                Notificaciones
            </div>

            <div class="notification-item">

                <div class="notification-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>

                    <div class="notification-title">
                        Nuevo usuario registrado
                    </div>

                    <div class="notification-time">
                        Hace 2 minutos
                    </div>

                </div>

            </div>

            <div class="notification-item">

                <div class="notification-icon">
                    <i class="fa-solid fa-book"></i>
                </div>

                <div>

                    <div class="notification-title">
                        Curso creado
                    </div>

                    <div class="notification-time">
                        Hace 15 minutos
                    </div>

                </div>

            </div>

            <div class="notification-item">

                <div class="notification-icon">
                    <i class="fa-solid fa-gear"></i>
                </div>

                <div>

                    <div class="notification-title">
                        Sistema iniciado
                    </div>

                    <div class="notification-time">
                        Hoy 09:30
                    </div>

                </div>

            </div>

            <div class="notification-footer">
                Ver todas →
            </div>

        </div>

    </div>

    <div class="topbar-profile">

        <div class="profile-avatar">

            <i class="fa-solid fa-user"></i>

        </div>

        <div class="profile-info">

            <span class="profile-name">
                <?= htmlspecialchars($_SESSION['user']['nombres'] ?? 'Usuario') ?>
            </span>

            <span class="profile-role">
                <?= $_SESSION['user']['rol_nombre'] ?? '' ?>
            </span>

        </div>

    </div>

</div>

</div>

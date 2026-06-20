<?php

$current = $_SERVER['REQUEST_URI'];

$breadcrumbs = [
    '/admin'     => ['Dashboard'],
    '/usuarios'  => ['Dashboard', 'Usuarios'],
    '/cursos'    => ['Dashboard', 'Cursos'],
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

 
<div class="topbar-right">

    <div class="notification-wrapper">

        <button id="notificationBtn" class="notification-btn">

            <i class="fa-solid fa-bell"></i>

            <span class="notification-count">3</span>

        </button>

        <div id="notificationPanel" class="notification-panel">

            <div class="notification-item">
                Nuevo usuario registrado
            </div>

            <div class="notification-item">
                Curso creado correctamente
            </div>

            <div class="notification-item">
                Sistema iniciado
            </div>

        </div>

    </div>

</div>
 

</div>

<div class="breadcrumbs">

    <?php foreach ($items as $index => $item): ?>

        <span><?= $item ?></span>

        <?php if ($index < count($items) - 1): ?>
            <span class="separator">›</span>
        <?php endif; ?>

    <?php endforeach; ?>

</div>
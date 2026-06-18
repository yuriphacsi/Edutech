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

<div class="breadcrumbs">

    <?php foreach ($items as $index => $item): ?>

        <span><?= $item ?></span>

        <?php if ($index < count($items) - 1): ?>
            <span class="separator">›</span>
        <?php endif; ?>

    <?php endforeach; ?>

</div>
<?php

use App\Helpers\Session;

$user = Session::get('user');
$rol = $user['rol'] ?? null;

?>

<div class="nav-buttons">

    <?php if ($rol == 1): ?>
        <a class="btn-nav" href="/Edutech/usuarios">Usuarios</a>
        <a class="btn-nav" href="/Edutech/cursos">Cursos</a>
        <a class="btn-nav" href="/Edutech/reservas">Reservas</a>
    <?php endif; ?>

    <?php if ($rol == 2): ?>
        <a class="btn-nav" href="/Edutech/cursos">Mis Cursos</a>
    <?php endif; ?>

    <?php if ($rol == 3): ?>
        <a class="btn-nav" href="/Edutech/mis-cursos">Mis Cursos</a>
    <?php endif; ?>

</div>
<?php $rol = $_SESSION['user']['rol'] ?? null; ?>

<ul>

    
    <?php if ($rol === 'admin'): ?>
        <li><a href="/Edutech/usuarios">Usuarios</a></li>
        <li><a href="/Edutech/cursos">Cursos</a></li>
        <li><a href="/Edutech/reservas">Reservas</a></li>
    <?php endif; ?>

    <?php if ($rol === 'asesor'): ?>
        <li><a href="/Edutech/cursos">Mis Cursos</a></li>
    <?php endif; ?>

    <?php if ($rol === 'alumno'): ?>
        <li><a href="/Edutech/mis-cursos">Mis Cursos</a></li>
    <?php endif; ?>


</ul>
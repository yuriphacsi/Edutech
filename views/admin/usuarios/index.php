<?php

use App\Helpers\Mask;

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios - EduTech</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #0f172a;
    color: #e2e8f0;
}

/* CONTENEDOR */
.container {
    padding: 100px 40px 40px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header h1 {
    font-size: 28px;
}

.btn {
    background: #2563eb;
    color: white;
    padding: 10px 15px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}

.btn:hover {
    background: #1d4ed8;
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(255,255,255,0.03);
    border-radius: 12px;
    overflow: hidden;
}

.table th, .table td {
    padding: 14px;
    text-align: left;
}

.table th {
    background: rgba(255,255,255,0.05);
    color: #94a3b8;
    font-size: 13px;
}

.table tr {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.table tr:hover {
    background: rgba(255,255,255,0.05);
}

/* BADGES */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.admin {
    background: #1e3a8a;
    color: #60a5fa;
}

.asesor {
    background: #14532d;
    color: #4ade80;
}

.alumno {
    background: #3b0764;
    color: #c084fc;
}

.inactivo {
    background: #7f1d1d;
    color: #f87171;
}

/* ACTIONS */
.actions a {
    margin-right: 10px;
    color: #60a5fa;
    text-decoration: none;
    font-size: 13px;
}

.actions a:hover {
    text-decoration: underline;
}

</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>👥 Gestión de Usuarios</h1>
        <a class="btn" href="/Edutech/usuarios/create">+ Nuevo Usuario</a>
    </div>

    <table class="table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($usuarios as $u): ?>

            <tr>
                <td><?= $u['id_usuario'] ?></td>
                <td>
                    <?= Mask::name($u['nombres']) ?>
                    <?= Mask::name($u['apellidos']) ?>
                </td>
                <td><?= Mask::email($u['correo']) ?></td>
                

                <td>
                    <?php if ($u['id_rol'] == 1): ?>
                        <span class="badge admin">Admin</span>
                    <?php elseif ($u['id_rol'] == 2): ?>
                        <span class="badge asesor">Asesor</span>
                    <?php else: ?>
                        <span class="badge alumno">Alumno</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($u['estado'] == 1): ?>
                        <span class="badge admin">Activo</span>
                    <?php else: ?>
                        <span class="badge inactivo">Inactivo</span>
                    <?php endif; ?>
                </td>

                <td class="actions">
                    <a href="/Edutech/usuarios/edit?id=<?= $u['id_usuario'] ?>">Editar</a>
                    <a href="/Edutech/usuarios/toggle?id=<?= $u['id_usuario'] ?>">Activar/Desactivar</a>
                    <a href="/Edutech/usuarios/delete?id=<?= $u['id_usuario']?>">Eliminar</a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>
</html>
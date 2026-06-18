<?php

use App\Helpers\Mask;

?>

<div class="users-page">

    <div class="users-card">

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

                        <a class="action-btn edit"
                        href="/Edutech/usuarios/edit?id=<?= $u['id_usuario'] ?>">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <a class="action-btn toggle"
                        href="/Edutech/usuarios/toggle?id=<?= $u['id_usuario'] ?>">
                            <i class="fa-solid fa-rotate"></i>
                        </a>

                        <a class="action-btn delete"
                        href="/Edutech/usuarios/delete?id=<?= $u['id_usuario'] ?>">
                            <i class="fa-solid fa-trash"></i>
                        </a>

                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>
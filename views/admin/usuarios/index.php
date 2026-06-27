<?php

use App\Helpers\Mask;

?>

<div class="users-card">

    <div class="stat-card">
        <span class="stat-title">Total Usuarios</span>
        <h2><?= $stats['total'] ?></h2>
    </div>

    <div class="stat-card">
        <span class="stat-title">Activos</span>
        <h2><?= $stats['activos'] ?></h2>
    </div>

    <div class="stat-card">
        <span class="stat-title">Inactivos</span>
        <h2><?= $stats['inactivos'] ?></h2>
    </div>

    <div class="stat-card">
        <span class="stat-title">Administradores</span>
        <h2><?= $stats['admins'] ?></h2>
    </div>

</div>

<div class="module-page">

    <div class="module-card">

        <div class="header">
            <h1>👥 Gestión de Usuarios</h1>
            <a class="btn" href="/Edutech/admin/usuarios/create">
                + Nuevo Usuario
            </a>
        </div>

        <form method="GET" action="/Edutech/admin/usuarios" class="search-form">

            <input 
                type="text" 
                name="q" 
                placeholder="Buscar por nombre o correo..."
                value="<?= $q ?? '' ?>"
            >

            <button type="submit">Buscar</button>

        </form>

        <table class="table">

            <thead>
                <tr>
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
                            <span class="badge activo">Activo</span>
                        <?php else: ?>
                            <span class="badge inactivo">Inactivo</span>
                        <?php endif; ?>
                    </td>

                    <td class="actions">

                        <a class="action-btn edit"
                           href="/Edutech/admin/usuarios/edit?id=<?= $u['id_usuario'] ?>">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form method="POST"
                              action="/Edutech/admin/usuarios/toggle"
                              style="display:inline;">

                            <input type="hidden" name="id" value="<?= $u['id_usuario'] ?>">

                            <button type="submit" class="action-btn toggle">
                                <i class="fa-solid fa-rotate"></i>
                            </button>

                        </form>

                        <form method="POST"
                            action="/Edutech/admin/usuarios/delete"
                            onsubmit="return confirmDelete(this);"
                            style="display:inline;">

                            <input type="hidden" name="id" value="<?= $u['id_usuario'] ?>">

                            <button type="submit" class="action-btn delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

        <script>
        function confirmDelete(form) {

            const warning =
                "⚠️ ESTÁS A PUNTO DE ELIMINAR ESTE USUARIO PERMANENTEMENTE.\n\n" +
                "Esta acción no se puede deshacer.\n\n" +
                "Escribe ELIMINAR para confirmar.";

            const input = prompt(warning);

            if (input !== "ELIMINAR") {
                alert("Eliminación cancelada por seguridad");
                return false;
            }

            return true;
        }
        </script>

    </div>

</div>
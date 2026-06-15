<h1>📚 Gestión de Cursos</h1>

<a href="/Edutech/cursos/create" class="btn">➕ Nuevo Curso</a>

<br><br>

<table border="0" width="100%" cellpadding="10" cellspacing="0" style="margin-top:20px; background:rgba(255,255,255,0.05); border-radius:10px;">
    <thead>
        <tr style="text-align:left; color:#94a3b8;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($cursos)): ?>
            <?php foreach ($cursos as $curso): ?>
                <tr>
                    <td><?= $curso['id_curso'] ?></td>
                    <td><?= $curso['nombre'] ?></td>
                    <td><?= $curso['nivel'] ?></td>
                    <td>
                        <?= $curso['estado'] ? 'Activo' : 'Inactivo' ?>
                    </td>
                    <td>

                        <a href="/Edutech/cursos/edit?id=<?= $curso['id_curso'] ?>"
                        style="color:#60a5fa; text-decoration:none;">
                            ✏️ Editar
                        </a>

                        &nbsp;|&nbsp;

                        <form action="/Edutech/cursos/delete" method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('¿Eliminar este curso? Esta acción no se puede deshacer.')">

                            <input type="hidden" name="id" value="<?= $curso['id_curso'] ?>">

                            <button type="submit"
                                    style="background:none;border:none;color:#ef4444;cursor:pointer;">
                                🗑 Eliminar
                            </button>

                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hay cursos registrados</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
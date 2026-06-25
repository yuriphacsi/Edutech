<div class="users-page">

    <div class="users-card">

        <div class="header">
            <h1>📚 Gestión de Cursos</h1>

            <a href="/Edutech/admin/cursos/create" class="btn">
                + Nuevo Curso
            </a>
        </div>

        <table class="table">

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Asesor</th>
                    <th>Nivel</th>
                    <th>Alumnos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($cursos)): ?>

                    <?php foreach ($cursos as $curso): ?>

                        <?php
                            $nivel = $curso['nivel'] ?? 'Basico';

                            $asesor = trim(
                                ($curso['asesor_nombre'] ?? '') . ' ' .
                                ($curso['asesor_apellido'] ?? '')
                            );

                            $totalAlumnos = (int) ($curso['total_alumnos'] ?? 0);
                            $cupoMaximo   = (int) ($curso['cupo_maximo'] ?? 30);

                            $estado = (int) ($curso['estado'] ?? 0);

                            $ocupacion = ($cupoMaximo > 0)
                                ? ($totalAlumnos / $cupoMaximo) * 100
                                : 0;

                            $badgeCupo = 'activo';

                            if ($ocupacion >= 100) {
                                $badgeCupo = 'inactivo';
                            } elseif ($ocupacion >= 80) {
                                $badgeCupo = 'asesor';
                            }
                        ?>

                        <tr>
                            <td><?= $curso['nombre'] ?></td>

                            <td>
                                <?= $asesor !== '' ? $asesor : 'Sin asesor' ?>
                            </td>

                            <td>
                                <?php if ($nivel === 'Basico'): ?>
                                    <span class="badge alumno">Básico</span>

                                <?php elseif ($nivel === 'Intermedio'): ?>
                                    <span class="badge asesor">Intermedio</span>

                                <?php else: ?>
                                    <span class="badge admin">Avanzado</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="badge <?= $badgeCupo ?>">
                                    <?= $totalAlumnos ?> / <?= $cupoMaximo ?>
                                </span>
                            </td>

                            <td>
                                <?php if ($estado === 1): ?>
                                    <span class="badge activo">Activo</span>
                                <?php else: ?>
                                    <span class="badge inactivo">Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td class="actions">

                                <a class="action-btn edit"
                                   href="/Edutech/admin/cursos/edit?id=<?= $curso['id_curso'] ?>">
                                    ✏️
                                </a>

                                <form method="POST"
                                      action="/Edutech/admin/cursos/delete"
                                      style="display:inline;"
                                      onsubmit="return confirm('¿Eliminar curso?');">

                                    <input type="hidden" name="id" value="<?= $curso['id_curso'] ?>">

                                    <button type="submit" class="action-btn delete">
                                        🗑
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7">No hay cursos registrados</td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
<div class="module-page">

    <div class="module-card">

        <div class="header">
            <h1><i class="fa-solid fa-graduation-cap"></i> Gestión de Cursos</h1>

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

                            if ($asesor === '') {
                                $asesor = 'Sin asesor';
                            }

                            $totalAlumnos = (int) ($curso['total_alumnos'] ?? 0);
                            $cupoMaximo   = (int) ($curso['cupo_maximo'] ?? 30);

                            $estado = (int) ($curso['estado'] ?? 0);

                            $ocupacion = ($cupoMaximo > 0)
                                ? round(($totalAlumnos / $cupoMaximo) * 100, 1)
                                : 0;

                            $badgeCupo = 'activo';

                            if ($ocupacion >= 100) {
                                $badgeCupo = 'danger';
                            } elseif ($ocupacion >= 80) {
                                $badgeCupo = 'warning';
                            } else {
                                $badgeCupo = 'success';
                            }
                        ?>

                        <tr>
                            <td><?= htmlspecialchars($curso['nombre']) ?></td>

                            <td>
                                <?= $asesor ?>
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
                                <span class="badge <?= $badgeCupo = 'cupo'; ?>">
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

                                <?php $idCurso = $curso['id_curso'] ?? 0; ?>

                                <a class="action-btn edit"
                                href="/Edutech/admin/cursos/edit?id=<?= $idCurso ?>">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form method="POST"
                                      action="/Edutech/admin/cursos/delete"
                                      style="display:inline;"
                                      onsubmit="return confirm('¿Eliminar curso?');">

                                    <input type="hidden" name="id" value="<?= $curso['id_curso'] ?>">

                                    <button type="submit" class="action-btn delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                                <a class="action-btn"
                                    href="/Edutech/admin/cursos/alumnos?id=<?= $curso['id_curso'] ?>">
                                    <i class="fa-solid fa-users"></i>
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6">No hay cursos registrados</td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
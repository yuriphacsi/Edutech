<div class="module-page">

    <div class="module-card">

        <div class="header">
            <h1>
                <i class="fa-solid fa-certificate"></i>
                Gestión de Certificados
            </h1>

            <a href="/Edutech/admin/certificados/create" class="btn">
                + Emitir Certificado
            </a>
        </div>

        <!-- RESUMEN (FUTURO: ESTADÍSTICAS) -->
        <div class="cert-stats">
            <div class="stat-box">
                <span>Total</span>
                <strong><?= count($certificados ?? []) ?></strong>
            </div>

            <div class="stat-box">
                <span>Activos</span>
                <strong>
                    <?= array_sum(array_map(fn($c) => $c['estado'] == 1 ? 1 : 0, $certificados ?? [])) ?>
                </strong>
            </div>
        </div>

        <table class="table">

            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Curso</th>
                    <th>Código</th>
                    <th>Horas</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($certificados)): ?>

                    <?php foreach ($certificados as $c): ?>

                        <?php
                            $alumno = trim(
                                ($c['alumno_nombre'] ?? '') . ' ' .
                                ($c['alumno_apellido'] ?? '')
                            );

                            $curso = $c['curso_nombre'] ?? 'Sin curso';
                            $estado = (int)($c['estado'] ?? 0);
                        ?>

                        <tr>

                            <td>
                                <strong><?= $alumno ?: 'Sin alumno' ?></strong>
                            </td>

                            <td>
                                <?= $curso ?>
                            </td>

                            <td>
                                <span class="badge">
                                    <?= $c['codigo'] ?>
                                </span>
                            </td>

                            <td>
                                <?= $c['horas'] ?> hrs
                            </td>

                            <td>
                                <?= $c['fecha_emision'] ?>
                            </td>

                            <td>
                                <?php if ($estado === 1): ?>
                                    <span class="badge activo">Emitido</span>
                                <?php else: ?>
                                    <span class="badge inactivo">Anulado</span>
                                <?php endif; ?>
                            </td>

                            <td class="actions">

                                <a class="action-btn view"
                                   href="/Edutech/admin/certificados/show?id=<?= $c['id_certificado'] ?>">
                                    👁
                                </a>

                                <a class="action-btn pdf"
                                   href="/Edutech/admin/certificados/pdf?id=<?= $c['id_certificado'] ?>"
                                   target="_blank">
                                    📄
                                </a>

                                <a class="action-btn download"
                                   href="/Edutech/admin/certificados/download?id=<?= $c['id_certificado'] ?>">
                                    ⬇
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7">No hay certificados emitidos</td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
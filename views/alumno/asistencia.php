<?php
function estadoAsistencia(array $a): array {
    $hoy = date('Y-m-d');

    if ($a['estado'] === 'Finalizada') {
        return ['Asistió', 'asistio'];
    }
    if ($a['estado'] === 'Cancelada') {
        return ['Cancelada', 'cancelada'];
    }
    if ($a['estado'] === 'Pendiente' && $a['fecha'] < $hoy) {
        return ['Falta', 'falta'];
    }
    return ['Programada', 'programada'];
}

$nombre = $_SESSION['user']['nombres'] ?? 'Alumno';
$total  = count($asistencias);
?>

<div class="asistencia-layout">

    <div class="asistencia-header">
        <div class="asistencia-header-text">
            <h2>Mi Asistencia</h2>
            <p>Historial de tus asesorías y clases, <?= htmlspecialchars($nombre) ?></p>
        </div>
    </div>

    <!-- ======== RESUMEN ======== -->
    <div class="asistencia-resumen">

        <div class="resumen-card">
            <span class="resumen-valor"><?= $resumen['porcentaje'] ?>%</span>
            <span class="resumen-label">Asistencia</span>
        </div>

        <div class="resumen-card asistio">
            <span class="resumen-valor"><?= $resumen['asistio'] ?></span>
            <span class="resumen-label">Asistió</span>
        </div>

        <div class="resumen-card programada">
            <span class="resumen-valor"><?= $resumen['programada'] ?></span>
            <span class="resumen-label">Programadas</span>
        </div>

        <div class="resumen-card falta">
            <span class="resumen-valor"><?= $resumen['falta'] ?></span>
            <span class="resumen-label">Faltas</span>
        </div>

        <div class="resumen-card cancelada">
            <span class="resumen-valor"><?= $resumen['cancelada'] ?></span>
            <span class="resumen-label">Canceladas</span>
        </div>

    </div>

    <!-- ======== LISTADO ======== -->
    <?php if ($total === 0): ?>

        <div class="cursos-vacio">
            <div class="vacio-icon">🗓️</div>
            <h3>Aún no tienes asistencias registradas</h3>
            <p>Cuando tengas asesorías agendadas, aparecerán aquí.</p>
        </div>

    <?php else: ?>

        <div class="asistencia-tabla-wrap">
            <table class="asistencia-tabla">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Asesor</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($asistencias as $a):
                        [$estadoTxt, $estadoClass] = estadoAsistencia($a);
                        $imagen = $a['imagen']
                            ? '/Edutech/public/img/' . htmlspecialchars($a['imagen'])
                            : null;
                    ?>
                    <tr>
                        <td>
                            <div class="curso-cell">
                                <?php if ($imagen): ?>
                                    <img src="<?= $imagen ?>" alt="<?= htmlspecialchars($a['curso_nombre']) ?>">
                                <?php endif; ?>
                                <span><?= htmlspecialchars($a['curso_nombre']) ?></span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($a['asesor_nombres'] . ' ' . $a['asesor_apellidos']) ?></td>
                        <td><?= date('d/m/Y', strtotime($a['fecha'])) ?></td>
                        <td><?= substr($a['hora_inicio'], 0, 5) ?> - <?= substr($a['hora_fin'], 0, 5) ?></td>
                        <td>
                            <span class="estado-pill estado-<?= $estadoClass ?>">
                                <?= $estadoTxt ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</div>
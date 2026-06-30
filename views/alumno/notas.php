<?php
// ── helpers ──────────────────────────────────────────────
function mnBadge(string $nombre): array {
    $map = [
        'Electricidad'   => ['#fef3c7', '#b45309'],
        'Agricultura'    => ['#dcfce7', '#15803d'],
        'Gastronomía'    => ['#fce7f3', '#be185d'],
        'Cirugía'        => ['#fee2e2', '#b91c1c'],
        'Anatomía'       => ['#dbeafe', '#1d4ed8'],
        'Oratoria'       => ['#e0e7ff', '#4338ca'],
        'Administración' => ['#d1fae5', '#065f46'],
        'Nutrición'      => ['#fef9c3', '#a16207'],
        'Economía'       => ['#ede9fe', '#6d28d9'],
        'Chongos'        => ['#f3e8ff', '#7c3aed'],
    ];
    foreach ($map as $key => $val) {
        if (stripos($nombre, $key) !== false) return $val;
    }
    return ['#f1f5f9', '#475569'];
}

function mnEstadoNota(float $nota, float $max): array {
    $pct = $max > 0 ? ($nota / $max) * 100 : 0;
    if ($pct >= 70)  return ['aprobado', 'Aprobado', '#15803d', '#dcfce7'];
    if ($pct >= 50)  return ['regular',  'Regular',  '#b45309', '#fef3c7'];
    return ['desaprobado', 'Desaprobado', '#b91c1c', '#fee2e2'];
}

$nombre = $_SESSION['user']['nombres'] ?? 'Alumno';

// ── agrupar notas por curso ──
$cursosAgrupados = [];
foreach ($notasPorCurso as $n) {
    $cid = $n['id_curso'];
    if (!isset($cursosAgrupados[$cid])) {
        $cursosAgrupados[$cid] = [
            'curso_nombre' => $n['curso_nombre'],
            'nivel'        => $n['nivel'],
            'imagen'       => $n['imagen'],
            'evaluaciones' => [],
        ];
    }
    $cursosAgrupados[$cid]['evaluaciones'][] = $n;
}

// ── calcular promedio general ──
$totalNotas = 0;
$sumaPct    = 0;
foreach ($notasPorCurso as $n) {
    $totalNotas++;
    $sumaPct += ($n['nota_maxima'] > 0) ? ($n['nota'] / $n['nota_maxima']) * 20 : 0;
}
$promedioGeneral = $totalNotas > 0 ? round($sumaPct / $totalNotas, 2) : 0;
$totalCursosNotas = count($cursosAgrupados);
$totalCalificaciones = count($calificacionesAsesorias);

// promedio de calificaciones de asesoría (escala 0.5-5.0)
$promCalif = 0;
if ($totalCalificaciones > 0) {
    $sumaCalif = array_sum(array_column($calificacionesAsesorias, 'puntuacion'));
    $promCalif = round($sumaCalif / $totalCalificaciones, 1);
}
?>

<!-- ── Encabezado ── -->
<div class="mn-page-header">
    <div class="mn-page-header-left">
        <h1>Mis Notas</h1>
        <p>Revisa tu rendimiento académico, <?= htmlspecialchars($nombre) ?></p>
    </div>
    <div class="mn-stats">
        <div class="mn-stat">
            <span class="mn-stat-num"><?= $promedioGeneral ?></span>
            <span class="mn-stat-label">Promedio (20)</span>
        </div>
        <div class="mn-stat-divider"></div>
        <div class="mn-stat">
            <span class="mn-stat-num"><?= $totalCursosNotas ?></span>
            <span class="mn-stat-label">Cursos evaluados</span>
        </div>
        <div class="mn-stat-divider"></div>
        <div class="mn-stat">
            <span class="mn-stat-num"><?= $totalNotas ?></span>
            <span class="mn-stat-label">Evaluaciones</span>
        </div>
    </div>
</div>

<!-- ── Tabs ── -->
<div class="mn-tabs">
    <button class="mn-tab active" id="tabNotas" onclick="mnCambiarTab('notas')">
        <i class="fa-solid fa-clipboard-list"></i> Notas por Curso
    </button>
    <button class="mn-tab" id="tabAsesorias" onclick="mnCambiarTab('asesorias')">
        <i class="fa-solid fa-star"></i> Calificaciones de Asesorías
    </button>
</div>

<!-- ════════════════════ TAB 1: NOTAS POR CURSO ════════════════════ -->
<div class="mn-tab-content" id="contentNotas">

    <?php if (empty($cursosAgrupados)): ?>

        <div class="mn-vacio">
            <div class="mn-vacio-icon">📊</div>
            <h3>Aún no tienes notas registradas</h3>
            <p>Tus evaluaciones aparecerán aquí una vez que tu asesor las registre</p>
        </div>

    <?php else: ?>

        <div class="mn-cursos-list">
            <?php foreach ($cursosAgrupados as $curso):
                [$badgeBg, $badgeColor] = mnBadge($curso['curso_nombre']);
                $imagen = $curso['imagen']
                    ? '/Edutech/public/img/' . htmlspecialchars($curso['imagen'])
                    : null;

                // promedio del curso
                $sumaCurso = 0;
                foreach ($curso['evaluaciones'] as $ev) {
                    $sumaCurso += ($ev['nota_maxima'] > 0) ? ($ev['nota'] / $ev['nota_maxima']) * 20 : 0;
                }
                $promCurso = count($curso['evaluaciones']) > 0
                    ? round($sumaCurso / count($curso['evaluaciones']), 2)
                    : 0;
                [$estClass, $estTxt, $estColor, $estBg] = mnEstadoNota($promCurso, 20);
            ?>

            <div class="mn-curso-card">

                <div class="mn-curso-header">
                    <div class="mn-curso-info">
                        <?php if ($imagen): ?>
                            <img src="<?= $imagen ?>" class="mn-curso-thumb" alt="<?= htmlspecialchars($curso['curso_nombre']) ?>">
                        <?php else: ?>
                            <div class="mn-curso-thumb mn-curso-thumb-placeholder">🎓</div>
                        <?php endif; ?>
                        <div>
                            <h3><?= htmlspecialchars($curso['curso_nombre']) ?></h3>
                            <span class="mn-nivel-pill nivel-<?= strtolower($curso['nivel']) ?>"><?= $curso['nivel'] ?></span>
                        </div>
                    </div>
                    <div class="mn-curso-promedio">
                        <span class="mn-promedio-num" style="color:<?= $estColor ?>"><?= $promCurso ?></span>
                        <span class="mn-promedio-chip" style="background:<?= $estBg ?>;color:<?= $estColor ?>">
                            <?= $estTxt ?>
                        </span>
                    </div>
                </div>

                <div class="mn-evaluaciones">
                    <table class="mn-tabla">
                        <thead>
                            <tr>
                                <th>Evaluación</th>
                                <th>Fecha</th>
                                <th>Nota</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($curso['evaluaciones'] as $ev):
                                [$evClass, $evTxt, $evColor, $evBg] = mnEstadoNota((float)$ev['nota'], (float)$ev['nota_maxima']);
                                $fecha = date('d M Y', strtotime($ev['fecha_evaluacion']));
                            ?>
                            <tr>
                                <td>
                                    <span class="mn-eval-nombre"><?= htmlspecialchars($ev['tipo_evaluacion']) ?></span>
                                    <?php if (!empty($ev['comentario'])): ?>
                                        <span class="mn-eval-comentario" title="<?= htmlspecialchars($ev['comentario']) ?>">
                                            <i class="fa-regular fa-comment-dots"></i>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="mn-fecha"><?= $fecha ?></td>
                                <td class="mn-nota-cell">
                                    <strong><?= number_format((float)$ev['nota'], 2) ?></strong>
                                    <span class="mn-nota-max">/ <?= number_format((float)$ev['nota_maxima'], 0) ?></span>
                                </td>
                                <td>
                                    <span class="mn-estado-pill" style="background:<?= $evBg ?>;color:<?= $evColor ?>">
                                        <?= $evTxt ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<!-- ════════════════════ TAB 2: CALIFICACIONES ASESORÍAS ════════════════════ -->
<div class="mn-tab-content" id="contentAsesorias" style="display:none;">

    <?php if (empty($calificacionesAsesorias)): ?>

        <div class="mn-vacio">
            <div class="mn-vacio-icon">⭐</div>
            <h3>Aún no has calificado asesorías</h3>
            <p>Las calificaciones que dejes a tus asesores aparecerán aquí</p>
        </div>

    <?php else: ?>

        <div class="mn-calif-resumen">
            <div class="mn-calif-resumen-num">
                <?= $promCalif ?> <span>/ 5.0</span>
            </div>
            <div class="mn-calif-resumen-stars">
                <?php
                    $estrellasLlenas = floor($promCalif);
                    $mediaEstrella   = ($promCalif - $estrellasLlenas) >= 0.5;
                    for ($i = 1; $i <= 5; $i++):
                        if ($i <= $estrellasLlenas) {
                            echo '<i class="fa-solid fa-star"></i>';
                        } elseif ($i == $estrellasLlenas + 1 && $mediaEstrella) {
                            echo '<i class="fa-solid fa-star-half-stroke"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star"></i>';
                        }
                    endfor;
                ?>
            </div>
            <p>Promedio de tus calificaciones a asesores</p>
        </div>

        <div class="mn-calif-list">
            <?php foreach ($calificacionesAsesorias as $cal):
                $fecha = date('d M Y', strtotime($cal['created_at']));
                $estrellasLlenasCal = floor($cal['puntuacion']);
                $mediaCal = ($cal['puntuacion'] - $estrellasLlenasCal) >= 0.5;
            ?>
            <div class="mn-calif-card">
                <div class="mn-calif-card-top">
                    <div>
                        <h4><?= htmlspecialchars($cal['asesor_nombres'] . ' ' . $cal['asesor_apellidos']) ?></h4>
                        <span class="mn-calif-curso"><?= htmlspecialchars($cal['curso_nombre']) ?></span>
                    </div>
                    <div class="mn-calif-stars-sm">
                        <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $estrellasLlenasCal) {
                                    echo '<i class="fa-solid fa-star"></i>';
                                } elseif ($i == $estrellasLlenasCal + 1 && $mediaCal) {
                                    echo '<i class="fa-solid fa-star-half-stroke"></i>';
                                } else {
                                    echo '<i class="fa-regular fa-star"></i>';
                                }
                            }
                        ?>
                        <span class="mn-calif-num"><?= number_format((float)$cal['puntuacion'], 1) ?></span>
                    </div>
                </div>
                <?php if (!empty($cal['comentario'])): ?>
                    <p class="mn-calif-comentario">"<?= htmlspecialchars($cal['comentario']) ?>"</p>
                <?php endif; ?>
                <span class="mn-calif-fecha"><i class="fa-regular fa-calendar"></i> <?= $fecha ?></span>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<script>
function mnCambiarTab(tab) {
    document.getElementById('tabNotas').classList.toggle('active', tab === 'notas');
    document.getElementById('tabAsesorias').classList.toggle('active', tab === 'asesorias');
    document.getElementById('contentNotas').style.display = tab === 'notas' ? 'block' : 'none';
    document.getElementById('contentAsesorias').style.display = tab === 'asesorias' ? 'block' : 'none';
}
</script>
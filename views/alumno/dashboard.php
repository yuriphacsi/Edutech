<?php
// Badge por área según el nombre del curso
function getBadge(string $nombre): array {
    $map = [
        'Electricidad'   => ['electricidad', 'Electricidad',  '#fef3c7', '#b45309'],
        'Agricultura'    => ['agricultura',  'Agricultura',   '#dcfce7', '#15803d'],
        'Gastronomía'    => ['gastronomia',  'Gastronomía',   '#fce7f3', '#be185d'],
        'Cirugía'        => ['salud',        'Salud',         '#fee2e2', '#b91c1c'],
        'Anatomía'       => ['medicina',     'Medicina',      '#dbeafe', '#1d4ed8'],
        'Oratoria'       => ['comunicacion', 'Comunicación',  '#e0e7ff', '#4338ca'],
        'Administración' => ['finanzas',     'Finanzas',      '#d1fae5', '#065f46'],
        'Nutrición'      => ['nutricion',    'Nutrición',     '#fef9c3', '#a16207'],
        'Economía'       => ['economia',     'Economía',      '#ede9fe', '#6d28d9'],
        'Bancaria'       => ['finanzas',     'Finanzas',      '#d1fae5', '#065f46'],
        'Chongos'        => ['administracion','Administración','#f3e8ff', '#7c3aed'],
    ];
    foreach ($map as $key => $val) {
        if (stripos($nombre, $key) !== false) return $val;
    }
    return ['default', 'Curso', '#f1f5f9', '#475569'];
}

$nombre           = $_SESSION['user']['nombres'] ?? 'Alumno';
$totalMisCursos   = count($misCursos);
$totalDisponibles = count($cursosDisponibles);
?>

<!-- ======== MODAL IMAGEN ======== -->
<div class="modal-img" id="modalImg" onclick="cerrarModal()">
    <span class="cerrar-modal">&times;</span>
    <img src="" id="modalImgSrc" alt="Vista ampliada" onclick="event.stopPropagation()">
</div>

<div class="alumno-layout">

    <!-- ======== PANEL FILTROS ======== -->
    <aside class="filtros-panel">

        <div class="filtros-card">
            <div class="filtros-header">
                <h3>Filtros</h3>
                <button class="filtros-limpiar" onclick="limpiarFiltros()">Limpiar</button>
            </div>

            <div class="filtro-grupo">
                <label class="filtro-label">Área de Estudio</label>
                <select class="filtro-select" id="filtroArea" onchange="filtrarCursos()">
                    <option value="">Todas las áreas</option>
                    <option value="electricidad">Electricidad</option>
                    <option value="agricultura">Agricultura</option>
                    <option value="gastronomia">Gastronomía</option>
                    <option value="salud">Salud</option>
                    <option value="medicina">Medicina</option>
                    <option value="comunicacion">Comunicación</option>
                    <option value="finanzas">Finanzas</option>
                    <option value="nutricion">Nutrición</option>
                    <option value="economia">Economía</option>
                    <option value="administracion">Administración</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label class="filtro-label">Nivel</label>
                <select class="filtro-select" id="filtroNivel" onchange="filtrarCursos()">
                    <option value="">Todos los niveles</option>
                    <option value="Basico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                </select>
            </div>

        </div>

    </aside>

    <!-- ======== ÁREA PRINCIPAL ======== -->
    <main class="cursos-area">

        <!-- ================= MIS CURSOS ================= -->
        <div class="cursos-header">
            <div class="cursos-header-text">
                <h2>Mis Cursos Activos</h2>
                <p>
                    <?php if ($totalMisCursos > 0): ?>
                        Mostrando <?= $totalMisCursos ?> curso(s) para <?= htmlspecialchars($nombre) ?>
                    <?php else: ?>
                        Aún no estás inscrito en ningún curso
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <?php if ($totalMisCursos === 0): ?>
            <div class="cursos-vacio">
                <div class="vacio-icon">🎓</div>
                <h3>Aún no tienes cursos</h3>
                <p>Inscríbete en un curso para comenzar tu aprendizaje</p>
            </div>
        <?php else: ?>

            <div class="cursos-grid" id="misCursosGrid">

                <?php foreach ($misCursos as $curso):
                    [$badgeClass, $badgeTxt, $badgeBg, $badgeColor] = getBadge($curso['nombre']);
                    $imagen = $curso['imagen']
                        ? '/Edutech/public/img/' . htmlspecialchars($curso['imagen'])
                        : null;
                ?>

                <div class="curso-card" data-badge="<?= $badgeClass ?>" data-nivel="<?= $curso['nivel'] ?>">

                    <div class="curso-img-wrap">
                        <?php if ($imagen): ?>
                            <img src="<?= $imagen ?>"
                                 alt="<?= htmlspecialchars($curso['nombre']) ?>"
                                 onclick="abrirModal('<?= $imagen ?>')"
                                 title="Clic para ampliar">
                        <?php else: ?>
                            <span class="curso-img-placeholder">🎓</span>
                        <?php endif; ?>
                    </div>

                    <div class="curso-card-body">

                        <span class="curso-badge"
                              style="background:<?= $badgeBg ?>; color:<?= $badgeColor ?>">
                            <?= $badgeTxt ?>
                        </span>

                        <h3 class="curso-nombre"><?= htmlspecialchars($curso['nombre']) ?></h3>
                        <p class="curso-desc"><?= htmlspecialchars($curso['descripcion']) ?></p>

                        <div class="curso-progreso-wrap">
                            <div class="curso-progreso-label">
                                <span>Progreso</span>
                                <span><?= $curso['progreso'] ?>%</span>
                            </div>
                            <div class="curso-progreso-bar">
                                <div class="curso-progreso-fill"
                                     style="width: <?= $curso['progreso'] ?>%"></div>
                            </div>
                        </div>

                    </div>

                    <div class="curso-card-footer">
                        <span class="curso-nivel-txt nivel-<?= strtolower($curso['nivel']) ?>">
                            <?= $curso['nivel'] ?>
                        </span>
                        <a href="#" class="btn-entrar">Ver curso</a>
                    </div>

                </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- ================= CURSOS DISPONIBLES ================= -->
        <div class="cursos-header" style="margin-top:50px;">
            <div class="cursos-header-text">
                <h2>Cursos disponibles</h2>
                <p>Inscríbete en nuevos cursos para ampliar tu aprendizaje</p>
            </div>
        </div>

        <?php if ($totalDisponibles === 0): ?>
            <div class="cursos-vacio">
                <div class="vacio-icon">📚</div>
                <h3>No hay cursos disponibles</h3>
                <p>Ya estás inscrito en todos los cursos activos</p>
            </div>
        <?php else: ?>

            <div class="cursos-grid" id="cursosDisponiblesGrid">

                <?php foreach ($cursosDisponibles as $curso):
                    [$badgeClass, $badgeTxt, $badgeBg, $badgeColor] = getBadge($curso['nombre']);
                    $imagen = $curso['imagen']
                        ? '/Edutech/public/img/' . htmlspecialchars($curso['imagen'])
                        : null;
                ?>

                <div class="curso-card" data-badge="<?= $badgeClass ?>" data-nivel="<?= $curso['nivel'] ?>">

                    <div class="curso-img-wrap">
                        <?php if ($imagen): ?>
                            <img src="<?= $imagen ?>"
                                 alt="<?= htmlspecialchars($curso['nombre']) ?>"
                                 onclick="abrirModal('<?= $imagen ?>')"
                                 title="Clic para ampliar">
                        <?php else: ?>
                            <span class="curso-img-placeholder">🎓</span>
                        <?php endif; ?>
                    </div>

                    <div class="curso-card-body">

                        <span class="curso-badge"
                              style="background:<?= $badgeBg ?>; color:<?= $badgeColor ?>">
                            <?= $badgeTxt ?>
                        </span>

                        <h3 class="curso-nombre"><?= htmlspecialchars($curso['nombre']) ?></h3>
                        <p class="curso-desc"><?= htmlspecialchars($curso['descripcion']) ?></p>

                    </div>

                    <div class="curso-card-footer">
                        <span class="curso-nivel-txt nivel-<?= strtolower($curso['nivel']) ?>">
                            <?= $curso['nivel'] ?>
                        </span>
                        <form method="POST" action="/Edutech/alumno/inscribirse">
                            <input type="hidden" name="curso_id" value="<?= $curso['id_curso'] ?>">
                            <button type="submit" class="btn-entrar">Inscribirme</button>
                        </form>
                    </div>

                </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </main>

</div>

<script>
// ---- Modal imagen ----
function abrirModal(src) {
    document.getElementById('modalImgSrc').src = src;
    document.getElementById('modalImg').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function cerrarModal() {
    document.getElementById('modalImg').classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});

// ---- Filtros ----
function filtrarCursos() {
    const area  = document.getElementById('filtroArea').value;
    const nivel = document.getElementById('filtroNivel').value;

    document.querySelectorAll('.curso-card').forEach(card => {
        const matchArea  = !area  || card.dataset.badge  === area;
        const matchNivel = !nivel || card.dataset.nivel === nivel;
        card.style.display = (matchArea && matchNivel) ? '' : 'none';
    });
}

function limpiarFiltros() {
    document.getElementById('filtroArea').value  = '';
    document.getElementById('filtroNivel').value = '';
    document.querySelectorAll('.curso-card').forEach(c => c.style.display = '');
}
</script>
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

$nombre      = $_SESSION['user']['nombres'] ?? 'Alumno';
$totalCursos = count($cursos);
?>

<div class="alumno-layout">

    <!-- ======== PANEL FILTROS ======== -->
    <aside class="filtros-panel">

        <div class="filtros-card">
            <div class="filtros-header">
                <h3>Filtros</h3>
                <button class="filtros-limpiar" onclick="limpiarFiltros()">Limpiar</button>
            </div>

            <!-- Área de estudio -->
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

            <!-- Nivel -->
            <div class="filtro-grupo">
                <label class="filtro-label">Nivel</label>
                <select class="filtro-select" id="filtroNivel" onchange="filtrarCursos()">
                    <option value="">Todos los niveles</option>
                    <option value="Basico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                </select>
            </div>

            <!-- Disponibilidad -->
            <div class="filtro-grupo">
                <label class="filtro-label">Disponibilidad</label>
                <div class="disponibilidad-grid">
                    <button class="disp-btn" onclick="toggleDisp(this)">Mañana</button>
                    <button class="disp-btn active" onclick="toggleDisp(this)">Tarde</button>
                    <button class="disp-btn" onclick="toggleDisp(this)">Noche</button>
                    <button class="disp-btn" onclick="toggleDisp(this)">Fines de semana</button>
                </div>
            </div>
        </div>

        <!-- CTA card -->
        <div class="cta-card">
            <h4>¿Quieres ser tutor?</h4>
            <p>Únete a nuestra red global y comparte tu conocimiento.</p>
            <button class="cta-btn">Postularme</button>
        </div>

    </aside>

    <!-- ======== ÁREA PRINCIPAL ======== -->
    <main class="cursos-area">

        <div class="cursos-header">
            <div class="cursos-header-text">
                <h2>Mis Cursos Activos</h2>
                <p>
                    <?php if ($totalCursos > 0): ?>
                        Mostrando <?= $totalCursos ?> curso<?= $totalCursos > 1 ? 's' : '' ?> para <?= htmlspecialchars($nombre) ?>
                    <?php else: ?>
                        Aún no estás inscrito en ningún curso
                    <?php endif; ?>
                </p>
            </div>

            <div class="vista-toggle">
                <button class="vista-btn active" title="Vista grid" onclick="setVista('grid', this)">
                    <i class="fa-solid fa-grip"></i>
                </button>
                <button class="vista-btn" title="Vista lista" onclick="setVista('lista', this)">
                    <i class="fa-solid fa-list"></i>
                </button>
            </div>
        </div>

        <?php if ($totalCursos === 0): ?>
            <!-- Estado vacío -->
            <div class="cursos-vacio">
                <div class="vacio-icon">🎓</div>
                <h3>Aún no tienes cursos</h3>
                <p>Cuando te inscribas en un curso, aparecerá aquí.</p>
            </div>
        <?php else: ?>
            <!-- Grid de cursos -->
            <div class="cursos-grid" id="cursosGrid">

                <?php foreach ($cursos as $curso):
                    [$badgeClass, $badgeTxt, $badgeBg, $badgeColor] = getBadge($curso['nombre']);
                    $imagen = $curso['imagen']
                        ? '/Edutech/public/img/' . htmlspecialchars($curso['imagen'])
                        : null;
                ?>
                <div class="curso-card" data-badge="<?= $badgeClass ?>" data-nivel="<?= $curso['nivel'] ?>">

                    <!-- Imagen -->
                    <!-- Imagen -->
                <div class="curso-img-wrap">
                    <?php if ($imagen): ?>
                        <img src="<?= $imagen ?>" 
                            alt="<?= htmlspecialchars($curso['nombre']) ?>"
                            onclick="abrirModal('<?= $imagen ?>')">
                    <?php else: ?>
                      <span class="curso-img-placeholder">🎓</span>
                    <?php endif; ?>
                </div>

                    <!-- Cuerpo -->
                    <div class="curso-card-body">
                        <span class="curso-badge"
                              style="background:<?= $badgeBg ?>; color:<?= $badgeColor ?>">
                            <?= $badgeTxt ?>
                        </span>

                        <h3 class="curso-nombre"><?= htmlspecialchars($curso['nombre']) ?></h3>
                        <p class="curso-desc"><?= htmlspecialchars($curso['descripcion']) ?></p>

                        <!-- Progreso -->
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

                    <!-- Footer -->
                    <div class="curso-card-footer">
                        <span class="curso-nivel-txt nivel-<?= strtolower($curso['nivel']) ?>">
                             <?= $curso['nivel'] ?>
                        </span>
                        <a href="#" class="btn-entrar">
                            Ver curso
                        </a>
                    </div>

                </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </main>

    <!-- Modal imagen -->
<div class="modal-img" id="modalImg" onclick="cerrarModal()">
    <span class="cerrar">&times;</span>
    <img src="" id="modalImgSrc" alt="Vista ampliada">
</div>
</div>

<script>
function toggleDisp(btn) {
    btn.classList.toggle('active');
}

function limpiarFiltros() {
    document.getElementById('filtroArea').value = '';
    document.getElementById('filtroNivel').value = '';
    document.querySelectorAll('.disp-btn').forEach(b => b.classList.remove('active'));
    filtrarCursos();
}

function filtrarCursos() {
    const area  = document.getElementById('filtroArea').value;
    const nivel = document.getElementById('filtroNivel').value;

    document.querySelectorAll('.curso-card').forEach(card => {
        const matchArea  = !area  || card.dataset.badge  === area;
        const matchNivel = !nivel || card.dataset.nivel === nivel;
        card.style.display = (matchArea && matchNivel) ? '' : 'none';
    });
}

function setVista(tipo, btn) {
    document.querySelectorAll('.vista-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const grid = document.getElementById('cursosGrid');
    if (!grid) return;
    if (tipo === 'lista') {
        grid.classList.add('cursos-lista');
    } else {
        grid.classList.remove('cursos-lista');
    }
}

function abrirModal(src) {
    document.getElementById('modalImgSrc').src = src;
    document.getElementById('modalImg').classList.add('open');
}

function cerrarModal() {
    document.getElementById('modalImg').classList.remove('open');
}

// Cerrar con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModal();
});

</script>
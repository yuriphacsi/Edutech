<?php
// ── helpers ──────────────────────────────────────────────
function getBadgeCursos(string $nombre): array {
    $map = [
        'Electricidad'   => ['electricidad',  'Electricidad',   '#fef3c7', '#b45309'],
        'Agricultura'    => ['agricultura',   'Agricultura',    '#dcfce7', '#15803d'],
        'Gastronomía'    => ['gastronomia',   'Gastronomía',    '#fce7f3', '#be185d'],
        'Cirugía'        => ['salud',         'Salud',          '#fee2e2', '#b91c1c'],
        'Anatomía'       => ['medicina',      'Medicina',       '#dbeafe', '#1d4ed8'],
        'Oratoria'       => ['comunicacion',  'Comunicación',   '#e0e7ff', '#4338ca'],
        'Administración' => ['finanzas',      'Finanzas',       '#d1fae5', '#065f46'],
        'Nutrición'      => ['nutricion',     'Nutrición',      '#fef9c3', '#a16207'],
        'Economía'       => ['economia',      'Economía',       '#ede9fe', '#6d28d9'],
        'Bancaria'       => ['finanzas',      'Finanzas',       '#d1fae5', '#065f46'],
        'Chongos'        => ['administracion','Administración', '#f3e8ff', '#7c3aed'],
    ];
    foreach ($map as $key => $val) {
        if (stripos($nombre, $key) !== false) return $val;
    }
    return ['default', 'Curso', '#f1f5f9', '#475569'];
}

$nombre      = $_SESSION['user']['nombres'] ?? 'Alumno';
$totalCursos = count($misCursos);
?>

<!-- ── Modal imagen ── -->
<div class="mc-modal" id="mcModal" onclick="mcCerrar()">
    <span class="mc-modal-close">&times;</span>
    <img src="" id="mcModalImg" alt="Vista ampliada" onclick="event.stopPropagation()">
</div>

<!-- ── Modal confirmar anular ── -->
<div class="mc-confirm-modal" id="mcConfirmModal">
    <div class="mc-confirm-box">
        <div class="mc-confirm-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3>¿Anular inscripción?</h3>
        <p id="mcConfirmTxt">¿Seguro que quieres anular tu inscripción en este curso?</p>
        <div class="mc-confirm-btns">
            <button class="mc-btn-secondary" onclick="mcCerrarConfirm()">
                <i class="fa-solid fa-xmark"></i> Cancelar
            </button>
            <button class="mc-btn-danger" onclick="mcEjecutarAnular()">
                <i class="fa-solid fa-trash"></i> Sí, anular
            </button>
        </div>
    </div>
</div>

<!-- Form oculto para anular -->
<form id="mcAnularForm" method="POST" action="/Edutech/alumno/anular" style="display:none;">
    <input type="hidden" name="curso_id" id="mcAnularCursoId">
</form>

<!-- ── Encabezado de página ── -->
<div class="mc-page-header">
    <div class="mc-page-header-left">
        <h1>Mis Cursos</h1>
        <p>Gestiona y continúa tu aprendizaje, <?= htmlspecialchars($nombre) ?></p>
    </div>
    <div class="mc-page-header-right">
        <div class="mc-stats">
            <div class="mc-stat">
                <span class="mc-stat-num"><?= $totalCursos ?></span>
                <span class="mc-stat-label">Inscritos</span>
            </div>
            <div class="mc-stat-divider"></div>
            <div class="mc-stat">
                <?php
                    $enProgreso  = count(array_filter($misCursos, fn($c) => ($c['progreso'] ?? 0) > 0 && ($c['progreso'] ?? 0) < 100));
                    $completados = count(array_filter($misCursos, fn($c) => ($c['progreso'] ?? 0) >= 100));
                ?>
                <span class="mc-stat-num"><?= $enProgreso ?></span>
                <span class="mc-stat-label">En progreso</span>
            </div>
            <div class="mc-stat-divider"></div>
            <div class="mc-stat">
                <span class="mc-stat-num"><?= $completados ?></span>
                <span class="mc-stat-label">Completados</span>
            </div>
        </div>
    </div>
</div>

<!-- ── Toolbar ── -->
<div class="mc-toolbar">
    <div class="mc-toolbar-left">
        <div class="mc-search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="mcSearch" placeholder="Buscar curso..." oninput="mcFiltrar()">
        </div>
        <select class="mc-select" id="mcNivel" onchange="mcFiltrar()">
            <option value="">Todos los niveles</option>
            <option value="Basico">Básico</option>
            <option value="Intermedio">Intermedio</option>
            <option value="Avanzado">Avanzado</option>
        </select>
        <select class="mc-select" id="mcEstado" onchange="mcFiltrar()">
            <option value="">Todo el progreso</option>
            <option value="sin-iniciar">Sin iniciar</option>
            <option value="en-progreso">En progreso</option>
            <option value="completado">Completado</option>
        </select>
    </div>
    <div class="mc-vista-toggle">
        <button class="mc-vista-btn active" id="btnGrid" onclick="mcVista('grid')" title="Vista cuadrícula">
            <i class="fa-solid fa-grip"></i>
        </button>
        <button class="mc-vista-btn" id="btnLista" onclick="mcVista('lista')" title="Vista lista">
            <i class="fa-solid fa-list"></i>
        </button>
    </div>
</div>

<!-- ── Contenido ── -->
<?php if ($totalCursos === 0): ?>

    <div class="mc-vacio">
        <div class="mc-vacio-icon">🎓</div>
        <h3>Aún no tienes cursos</h3>
        <p>Visita el Dashboard para inscribirte en cursos disponibles</p>
        <a href="/Edutech/alumno" class="mc-btn-primary">
            <i class="fa-solid fa-compass"></i> Explorar cursos
        </a>
    </div>

<?php else: ?>

    <div class="mc-grid" id="mcGrid">

        <?php foreach ($misCursos as $curso):
            [$badgeClass, $badgeTxt, $badgeBg, $badgeColor] = getBadgeCursos($curso['nombre']);
            $progreso = (int)($curso['progreso'] ?? 0);
            $imagen   = $curso['imagen']
                ? '/Edutech/public/img/' . htmlspecialchars($curso['imagen'])
                : null;

            if ($progreso >= 100)  $estadoClass = 'completado';
            elseif ($progreso > 0) $estadoClass = 'en-progreso';
            else                   $estadoClass = 'sin-iniciar';

            $asesorNombre = isset($curso['asesor_nombres'])
                ? htmlspecialchars($curso['asesor_nombres'] . ' ' . $curso['asesor_apellidos'])
                : 'Sin asesor asignado';

            $fechaInsc = isset($curso['fecha_inscripcion'])
                ? date('d M Y', strtotime($curso['fecha_inscripcion']))
                : '—';
        ?>

        <div class="mc-card"
             data-nombre="<?= strtolower(htmlspecialchars($curso['nombre'])) ?>"
             data-nivel="<?= $curso['nivel'] ?>"
             data-estado="<?= $estadoClass ?>">

            <!-- imagen -->
            <div class="mc-card-img">
                <?php if ($imagen): ?>
                    <img src="<?= $imagen ?>"
                         alt="<?= htmlspecialchars($curso['nombre']) ?>"
                         onclick="mcAbrir('<?= $imagen ?>')"
                         title="Clic para ampliar">
                <?php else: ?>
                    <span class="mc-card-img-placeholder">🎓</span>
                <?php endif; ?>

                <span class="mc-nivel-badge nivel-<?= strtolower($curso['nivel']) ?>">
                    <?= $curso['nivel'] ?>
                </span>

                <?php if ($progreso >= 100): ?>
                    <span class="mc-estado-chip mc-estado-completado">
                        <i class="fa-solid fa-circle-check"></i> Completado
                    </span>
                <?php elseif ($progreso > 0): ?>
                    <span class="mc-estado-chip mc-estado-progreso">
                        <i class="fa-solid fa-spinner"></i> En progreso
                    </span>
                <?php else: ?>
                    <span class="mc-estado-chip mc-estado-sin-iniciar">
                        <i class="fa-regular fa-circle"></i> Sin iniciar
                    </span>
                <?php endif; ?>
            </div>

            <!-- cuerpo -->
            <div class="mc-card-body">

                <span class="mc-badge"
                      style="background:<?= $badgeBg ?>;color:<?= $badgeColor ?>">
                    <?= $badgeTxt ?>
                </span>

                <h3 class="mc-card-nombre"><?= htmlspecialchars($curso['nombre']) ?></h3>
                <p class="mc-card-desc"><?= htmlspecialchars($curso['descripcion']) ?></p>

                <div class="mc-card-meta">
                    <span><i class="fa-solid fa-user-tie"></i> <?= $asesorNombre ?></span>
                    <span><i class="fa-regular fa-calendar"></i> <?= $fechaInsc ?></span>
                </div>

                <div class="mc-progreso-wrap">
                    <div class="mc-progreso-top">
                        <span>Progreso del curso</span>
                        <span class="mc-progreso-pct"><?= $progreso ?>%</span>
                    </div>
                    <div class="mc-progreso-bar">
                        <div class="mc-progreso-fill <?= $progreso >= 100 ? 'mc-progreso-completo' : '' ?>"
                             style="width:<?= $progreso ?>%"></div>
                    </div>
                </div>

            </div>

            <!-- footer -->
            <div class="mc-card-footer">
                <?php if ($progreso >= 100): ?>
                    <a href="#" class="mc-btn-secondary">
                        <i class="fa-solid fa-rotate-left"></i> Repasar
                    </a>
                    <div class="mc-footer-right">
                        <a href="#" class="mc-btn-primary">
                            <i class="fa-solid fa-certificate"></i> Certificado
                        </a>
                        <button class="mc-btn-anular"
                                onclick="mcConfirmarAnular(<?= $curso['id_curso'] ?>, '<?= htmlspecialchars($curso['nombre'], ENT_QUOTES) ?>')"
                                title="Anular inscripción">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                <?php elseif ($progreso > 0): ?>
                    <span class="mc-progreso-txt">
                        <i class="fa-solid fa-clock"></i> Continúa donde lo dejaste
                    </span>
                    <div class="mc-footer-right">
                        <a href="#" class="mc-btn-primary">
                            <i class="fa-solid fa-play"></i> Continuar
                        </a>
                        <button class="mc-btn-anular"
                                onclick="mcConfirmarAnular(<?= $curso['id_curso'] ?>, '<?= htmlspecialchars($curso['nombre'], ENT_QUOTES) ?>')"
                                title="Anular inscripción">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                <?php else: ?>
                    <span class="mc-progreso-txt">
                        <i class="fa-solid fa-rocket"></i> ¡Listo para empezar!
                    </span>
                    <div class="mc-footer-right">
                        <a href="#" class="mc-btn-primary">
                            <i class="fa-solid fa-play"></i> Comenzar
                        </a>
                        <button class="mc-btn-anular"
                                onclick="mcConfirmarAnular(<?= $curso['id_curso'] ?>, '<?= htmlspecialchars($curso['nombre'], ENT_QUOTES) ?>')"
                                title="Anular inscripción">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <!-- Sin resultados -->
    <div class="mc-no-resultados" id="mcNoResultados" style="display:none;">
        <div class="mc-vacio-icon">🔍</div>
        <h3>Sin resultados</h3>
        <p>No hay cursos que coincidan con tu búsqueda</p>
        <button class="mc-btn-secondary" onclick="mcLimpiarFiltros()">
            <i class="fa-solid fa-xmark"></i> Limpiar filtros
        </button>
    </div>

<?php endif; ?>

<script>
// ── Modal imagen ──
function mcAbrir(src) {
    document.getElementById('mcModalImg').src = src;
    document.getElementById('mcModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function mcCerrar() {
    document.getElementById('mcModal').classList.remove('open');
    document.body.style.overflow = '';
}

// ── Modal confirmar anular ──
let mcCursoIdPendiente = null;

function mcConfirmarAnular(cursoId, nombreCurso) {
    mcCursoIdPendiente = cursoId;
    document.getElementById('mcConfirmTxt').textContent =
        '¿Seguro que quieres anular tu inscripción en "' + nombreCurso + '"? Esta acción no se puede deshacer.';
    document.getElementById('mcConfirmModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function mcCerrarConfirm() {
    mcCursoIdPendiente = null;
    document.getElementById('mcConfirmModal').classList.remove('open');
    document.body.style.overflow = '';
}
function mcEjecutarAnular() {
    if (!mcCursoIdPendiente) return;
    document.getElementById('mcAnularCursoId').value = mcCursoIdPendiente;
    document.getElementById('mcAnularForm').submit();
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { mcCerrar(); mcCerrarConfirm(); }
});

// ── Vista grid / lista ──
function mcVista(tipo) {
    const grid = document.getElementById('mcGrid');
    document.getElementById('btnGrid').classList.toggle('active', tipo === 'grid');
    document.getElementById('btnLista').classList.toggle('active', tipo === 'lista');
    if (grid) grid.classList.toggle('mc-lista', tipo === 'lista');
}

// ── Filtros ──
function mcFiltrar() {
    const q      = (document.getElementById('mcSearch')?.value || '').toLowerCase();
    const nivel  =  document.getElementById('mcNivel')?.value  || '';
    const estado =  document.getElementById('mcEstado')?.value || '';

    let visibles = 0;
    document.querySelectorAll('.mc-card').forEach(card => {
        const okNombre = !q      || card.dataset.nombre.includes(q);
        const okNivel  = !nivel  || card.dataset.nivel  === nivel;
        const okEstado = !estado || card.dataset.estado === estado;
        const mostrar  = okNombre && okNivel && okEstado;
        card.style.display = mostrar ? '' : 'none';
        if (mostrar) visibles++;
    });

    const noRes = document.getElementById('mcNoResultados');
    if (noRes) noRes.style.display = visibles === 0 ? 'block' : 'none';
}

function mcLimpiarFiltros() {
    document.getElementById('mcSearch').value  = '';
    document.getElementById('mcNivel').value   = '';
    document.getElementById('mcEstado').value  = '';
    mcFiltrar();
}
</script>
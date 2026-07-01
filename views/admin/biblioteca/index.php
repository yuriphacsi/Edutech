<div class="module-page">

    <div class="module-card">

        <div class="header">

            <h1>
                <i class="fa-solid fa-book-open"></i>
                Biblioteca Virtual
            </h1>

            <?php if ($rol === 1): ?>

                <a href="/Edutech/admin/biblioteca/create" class="btn">
                    <i class="fa-solid fa-plus"></i>
                    Nuevo Libro
                </a>

            <?php endif; ?>

        </div>

        <div class="stats-grid">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-book"></i>
                </div>

                <span class="stat-label">
                    Total Libros
                </span>

                <h2><?= count($libros) ?></h2>

            </div>

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>

                <span class="stat-label">
                    PDFs
                </span>

                <h2>
                    <?= count(array_filter($libros, fn($l)=>!empty($l['archivo_pdf']))) ?>
                </h2>

            </div>

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-link"></i>
                </div>

                <span class="stat-label">
                    Enlaces
                </span>

                <h2>
                    <?= count(array_filter($libros, fn($l)=>!empty($l['enlace']))) ?>
                </h2>

            </div>

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <span class="stat-label">
                    Categorías
                </span>

                <h2>
                    <?= count(array_unique(array_column($libros,'categoria'))) ?>
                </h2>

            </div>

        </div>

        <div class="biblioteca-toolbar">

        <form method="GET"
            action="/Edutech/admin/biblioteca"
            class="biblioteca-buscador">

            <input
                type="text"
                name="q"
                placeholder="Buscar libros..."
                value="<?= htmlspecialchars($busqueda) ?>">

            <button class="btn">

                <i class="fa-solid fa-magnifying-glass"></i>

                Buscar

            </button>

        </form>

        </div>

        <div class="biblioteca-grid">

            <?php if (!empty($libros)): ?>

                <?php foreach ($libros as $libro): ?>

                    <div class="libro-card">

                        <div class="libro-portada">
                            <?php if (!empty($libro['portada'])): ?>
                                <img src="/Edutech/public/uploads/<?= htmlspecialchars($libro['portada']) ?>" alt="Portada">
                            <?php else: ?>
                                <i class="fa-solid fa-book"></i>
                            <?php endif; ?>
                        </div>

                        <div class="libro-info">
                            <h3><?= htmlspecialchars($libro['titulo']) ?></h3>
                            <p class="libro-autor"><?= htmlspecialchars($libro['autor']) ?></p>

                            <?php if (!empty($libro['categoria'])): ?>
                                <span class="badge categoria"><?= htmlspecialchars($libro['categoria']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="libro-acciones">

                            <a class="action-btn"
                               href="/Edutech/admin/biblioteca/show?id=<?= $libro['id_biblioteca'] ?>">
                                <i class="fa-solid fa-eye"></i> Leer
                            </a>

                            <?php if ($rol === 1): ?>

                                <a class="action-btn edit"
                                   href="/Edutech/admin/biblioteca/edit?id=<?= $libro['id_biblioteca'] ?>">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form method="POST"
                                      action="/Edutech/admin/biblioteca/delete"
                                      style="display:inline;"
                                      onsubmit="return confirm('¿Eliminar este libro?');">

                                    <input type="hidden" name="id" value="<?= $libro['id_biblioteca'] ?>">

                                    <button type="submit" class="action-btn delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p>No se encontraron libros en la biblioteca.</p>

            <?php endif; ?>

        </div>

    </div>

</div>

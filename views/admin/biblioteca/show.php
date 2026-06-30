<div class="module-page">

    <div class="module-card libro-detalle">

        <div class="header">
            <h1><i class="fa-solid fa-book-open"></i> <?= htmlspecialchars($libro['titulo']) ?></h1>

            <a href="/Edutech/admin/biblioteca" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="libro-detalle-contenido">

            <div class="libro-portada-grande">
                <?php if (!empty($libro['portada'])): ?>
                    <img src="/Edutech/public/uploads/<?= htmlspecialchars($libro['portada']) ?>" alt="Portada">
                <?php else: ?>
                    <i class="fa-solid fa-book"></i>
                <?php endif; ?>
            </div>

            <div class="libro-detalle-info">

                <p><strong>Autor:</strong> <?= htmlspecialchars($libro['autor']) ?></p>

                <?php if (!empty($libro['categoria'])): ?>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($libro['categoria']) ?></p>
                <?php endif; ?>

                <?php if (!empty($libro['descripcion'])): ?>
                    <p><strong>Descripcion:</strong><br><?= nl2br(htmlspecialchars($libro['descripcion'])) ?></p>
                <?php endif; ?>

                <div class="libro-detalle-acciones">

                    <?php if (!empty($libro['archivo_pdf'])): ?>
                        <a class="btn"
                           href="/Edutech/public/uploads/<?= htmlspecialchars($libro['archivo_pdf']) ?>"
                           target="_blank">
                            <i class="fa-solid fa-file-pdf"></i> Descargar PDF
                        </a>
                    <?php elseif (!empty($libro['enlace']) && $libro['enlace'] !== '#'): ?>
                        <a class="btn" href="<?= htmlspecialchars($libro['enlace']) ?>" target="_blank">
                            <i class="fa-solid fa-up-right-from-square"></i> Abrir enlace
                        </a>
                    <?php else: ?>
                        <span class="badge inactivo">Sin archivo disponible</span>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

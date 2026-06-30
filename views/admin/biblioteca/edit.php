<div class="module-page">

    <div class="module-card">

        <div class="header">
            <h1><i class="fa-solid fa-book-open"></i> Editar Libro</h1>
        </div>

        <form method="POST"
              action="/Edutech/admin/biblioteca/update"
              enctype="multipart/form-data"
              class="form-grid">

            <input type="hidden" name="id_libro" value="<?= $libro['id_libro'] ?>">

            <div class="form-group">
                <label>Titulo</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo']) ?>" required>
            </div>

            <div class="form-group">
                <label>Autor</label>
                <input type="text" name="autor" value="<?= htmlspecialchars($libro['autor']) ?>" required>
            </div>

            <div class="form-group">
                <label>Categoria</label>
                <input type="text" name="categoria" value="<?= htmlspecialchars($libro['categoria'] ?? '') ?>">
            </div>

            <div class="form-group full">
                <label>Descripcion</label>
                <textarea name="descripcion" rows="4"><?= htmlspecialchars($libro['descripcion'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Portada (imagen)</label>
                <input type="file" name="portada" accept="image/*">
                <?php if (!empty($libro['portada'])): ?>
                    <small>Actual: <?= htmlspecialchars($libro['portada']) ?></small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Archivo PDF</label>
                <input type="file" name="archivo_pdf" accept="application/pdf">
                <?php if (!empty($libro['archivo_pdf'])): ?>
                    <small>Actual: <?= htmlspecialchars($libro['archivo_pdf']) ?></small>
                <?php endif; ?>
            </div>

            <div class="form-group full">
                <label>Enlace externo (opcional)</label>
                <input type="text" name="enlace" value="<?= htmlspecialchars($libro['enlace'] ?? '') ?>">
            </div>

            <div class="form-actions full">
                <a href="/Edutech/admin/biblioteca" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn">Actualizar Libro</button>
            </div>

        </form>

    </div>

</div>

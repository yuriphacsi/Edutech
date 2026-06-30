<div class="module-page">

    <div class="module-card">

        <div class="header">
            <h1><i class="fa-solid fa-book-open"></i> Nuevo Libro</h1>
        </div>

        <form method="POST"
              action="/Edutech/admin/biblioteca/store"
              enctype="multipart/form-data"
              class="form-grid">

            <div class="form-group">
                <label>Titulo</label>
                <input type="text" name="titulo" required>
            </div>

            <div class="form-group">
                <label>Autor</label>
                <input type="text" name="autor" required>
            </div>

            <div class="form-group">
                <label>Categoria</label>
                <input type="text" name="categoria">
            </div>

            <div class="form-group full">
                <label>Descripcion</label>
                <textarea name="descripcion" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Portada (imagen)</label>
                <input type="file" name="portada" accept="image/*">
            </div>

            <div class="form-group">
                <label>Archivo PDF</label>
                <input type="file" name="archivo_pdf" accept="application/pdf">
            </div>

            <div class="form-group full">
                <label>Enlace externo (opcional, si no se sube PDF)</label>
                <input type="text" name="enlace" placeholder="https://...">
            </div>

            <div class="form-actions full">
                <a href="/Edutech/admin/biblioteca" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn">Guardar Libro</button>
            </div>

        </form>

    </div>

</div>

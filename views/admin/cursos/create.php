<div class="form-page">

    <div class="form-card">

        <div class="form-header">

            <h1>
                <i class="fa-solid fa-book-medical"></i>
                Crear Curso
            </h1>

            <a href="/Edutech/admin/cursos" class="back-link">
                ← Volver a Cursos
            </a>

        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="/Edutech/admin/cursos/store"
              method="POST"
              enctype="multipart/form-data">

            <div class="form-group">
                <label>Nombre del curso</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" required></textarea>
            </div>

            <div class="form-group">
                <label>Nivel</label>
                <select name="nivel" required>
                    <option value="">Seleccione nivel</option>
                    <option value="Basico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                </select>
            </div>

            <div class="form-group">
                <label>Asesor</label>
                <select name="id_asesor" required>
                    <option value="">Seleccione asesor</option>

                    <?php foreach ($asesores as $a): ?>
                        <option value="<?= $a['id_asesor'] ?>">
                            <?= $a['nombres'] . ' ' . $a['apellidos'] ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group">
                <label>Cupo máximo</label>
                <input type="number" name="cupo_maximo" value="30" min="1" required>
            </div>

            <div class="form-group">
                <label>Imagen del curso</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

            <button class="btn-save" type="submit">
                Crear Curso
            </button>

        </form>

    </div>

</div>
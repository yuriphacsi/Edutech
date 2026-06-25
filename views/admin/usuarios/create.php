<div class="form-page">

    <div class="form-card">

        <div class="form-header">

            <h1>
                <i class="fa-solid fa-user-plus"></i>
                Crear Usuario
            </h1>

            <a href="/Edutech/admin/usuarios" class="back-link">
                Volver a Usuarios
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

        <form method="POST" action="/Edutech/admin/usuarios/store">

            <div class="form-group">
                <label>Nombres</label>
                <input type="text" name="nombres" required>
            </div>

            <div class="form-group">
                <label>Apellidos</label>
                <input type="text" name="apellidos" required>
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Rol</label>
                <select name="id_rol" required>
                    <option value="">Seleccionar rol</option>
                    <option value="1">Admin</option>
                    <option value="2">Asesor</option>
                    <option value="3">Alumno</option>
                </select>
            </div>

            <button class="btn-save" type="submit">
                Guardar Usuario
            </button>

        </form>

    </div>

</div>
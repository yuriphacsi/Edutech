<div class="form-page">

    <div class="form-card">

        <div class="form-header">

            <h1>
                <i class="fa-solid fa-user-pen"></i>
                Editar Usuario
            </h1>

            <a href="/Edutech/admin/usuarios" class="back-link">
                Volver a Usuarios
            </a>

        </div>

        <form action="/Edutech/admin/usuarios/update" method="POST">

            <input
                type="hidden"
                name="id_usuario"
                value="<?= $usuario['id_usuario'] ?>"
            >

            <div class="form-group">
                <label>Nombres</label>
                <input
                    type="text"
                    name="nombres"
                    value="<?= htmlspecialchars($usuario['nombres']) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Apellidos</label>
                <input
                    type="text"
                    name="apellidos"
                    value="<?= htmlspecialchars($usuario['apellidos']) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input
                    type="email"
                    name="correo"
                    value="<?= htmlspecialchars($usuario['correo']) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Rol</label>

                <select name="id_rol" required>

                    <option value="1"
                        <?= $usuario['id_rol'] == 1 ? 'selected' : '' ?>>
                        Administrador
                    </option>

                    <option value="2"
                        <?= $usuario['id_rol'] == 2 ? 'selected' : '' ?>>
                        Asesor
                    </option>

                    <option value="3"
                        <?= $usuario['id_rol'] == 3 ? 'selected' : '' ?>>
                        Alumno
                    </option>

                </select>
            </div>

            <button class="btn-save" type="submit">
                Actualizar Usuario
            </button>

        </form>

    </div>
</div>
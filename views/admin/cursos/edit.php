<div class="form-page">

    <div class="form-card">

        <div class="form-header">

            <h1>
                <i class="fa-solid fa-pen-to-square"></i>
                Editar Curso
            </h1>

            <a href="/Edutech/admin/cursos" class="back-link">
                ⬅ Volver
            </a>

        </div>

        <form action="/Edutech/admin/cursos/update" method="POST">

            <input type="hidden" name="id_curso" value="<?= $curso['id_curso'] ?>">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre"
                       value="<?= $curso['nombre'] ?? '' ?>"
                       required>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion"
                          rows="4"><?= $curso['descripcion'] ?? '' ?></textarea>
            </div>

            <div class="form-group">
                <label>Nivel</label>
                <select name="nivel">
                    <option value="Basico" <?= ($curso['nivel'] ?? '') === 'Basico' ? 'selected' : '' ?>>Básico</option>
                    <option value="Intermedio" <?= ($curso['nivel'] ?? '') === 'Intermedio' ? 'selected' : '' ?>>Intermedio</option>
                    <option value="Avanzado" <?= ($curso['nivel'] ?? '') === 'Avanzado' ? 'selected' : '' ?>>Avanzado</option>
                </select>
            </div>

            <div class="form-group">
                <label>Asesor</label>
                <select name="id_asesor">

                    <option value="">Sin asesor</option>

                    <?php foreach ($asesores as $asesor): ?>

                        <?php
                            $nombre = $asesor['nombres'] . ' ' . $asesor['apellidos'];
                            $selected = ($curso['id_asesor'] ?? null) == $asesor['id_asesor']
                                ? 'selected'
                                : '';
                        ?>

                        <option value="<?= $asesor['id_asesor'] ?>" <?= $selected ?>>
                            <?= $nombre ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group">
                <label>Cupo máximo de estudiantes</label>

                <input
                    type="number"
                    name="cupo_maximo"
                    value="<?= htmlspecialchars($curso['cupo_maximo'] ?? 30) ?>"
                    min="1"
                    required
                >
            </div>

            <div class="form-group">
                <label>Estado</label>
                <select name="estado">
                    <option value="1" <?= (int)($curso['estado'] ?? 0) === 1 ? 'selected' : '' ?>>
                        Activo
                    </option>
                    <option value="0" <?= (int)($curso['estado'] ?? 0) === 0 ? 'selected' : '' ?>>
                        Inactivo
                    </option>
                </select>
            </div>

            <button class="btn-save" type="submit">
                Actualizar Curso
            </button>

        </form>

    </div>

</div>
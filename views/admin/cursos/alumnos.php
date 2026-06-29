<div class="form-page">

    <div class="form-card">

        <div class="form-header">

            <h1>
                <i class="fa-solid fa-users"></i>
                Alumnos del curso
            </h1>

            <a href="/Edutech/admin/cursos" class="back-link">
                ⬅ Volver
            </a>

        </div>

        <table class="table">

            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Fecha inscripción</th>
                </tr>
            </thead>

            <tbody>

            <?php if (!empty($alumnos)): ?>

                <?php foreach ($alumnos as $a): ?>

                    <tr>
                        <td>
                            <?= $a['nombres'] . ' ' . $a['apellidos'] ?>
                        </td>

                        <td>
                            <?= $a['created_at'] ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="2">No hay alumnos inscritos</td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
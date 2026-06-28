<div class="form-page">

    <div class="form-card">

        <div class="form-header">

            <h1>
                <i class="fa-solid fa-certificate"></i>
                Emitir Certificado
            </h1>

            <a href="/Edutech/admin/certificados" class="back-link">
                Volver a Certificados
            </a>

        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/Edutech/admin/certificados/store">

            <!-- ALUMNO -->
            <div class="form-group">
                <label>Alumno</label>

                <select name="id_alumno" id="id_alumno" required>

                    <option value="">Seleccionar alumno</option>

                    <?php foreach ($alumnos as $a): ?>
                        <option value="<?= $a['id_alumno'] ?>">
                            <?= $a['nombres'] ?> <?= $a['apellidos'] ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- CURSO -->
            <div class="form-group">
                <label>Curso</label>

                <select
                    name="id_curso"
                    id="id_curso"
                    required
                    disabled
                >

                    <option value="">
                        Primero seleccione un alumno
                    </option>

                </select>

            </div>

            <!-- ASESOR -->
            <div class="form-group">
                <label>Asesor (opcional)</label>
                <select name="id_asesor">
                    <option value="">Sin asesor</option>

                    <?php foreach ($asesores as $a): ?>
                        <option value="<?= $a['id_asesor'] ?>">
                            <?= $a['nombres'] . ' ' . $a['apellidos'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- HORAS -->
            <div class="form-group">
                <label>Horas académicas</label>
                <input type="number" name="horas" min="1" value="1" required>
            </div>

            <!-- DESCRIPCIÓN -->
            <div class="form-group">
                <label>Descripción del certificado</label>
                <textarea name="descripcion" rows="3" required></textarea>
            </div>

            <button class="btn-save" type="submit">
                Emitir Certificado
            </button>

        </form>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const alumno = document.getElementById("id_alumno");
    const curso = document.getElementById("id_curso");

    alumno.addEventListener("change", () => {

        const id = alumno.value;

        curso.innerHTML = "";

        if (!id) {

            curso.disabled = true;

            curso.innerHTML =
                '<option>Primero seleccione un alumno</option>';

            return;
        }

        fetch(`/Edutech/admin/certificados/cursos?id_alumno=${id}`)

            .then(r => r.json())

            .then(data => {

                curso.disabled = false;

                curso.innerHTML =
                    '<option value="">Seleccione un curso</option>';

                data.forEach(c => {

                    curso.innerHTML +=
                        `<option value="${c.id_curso}">
                            ${c.nombre}
                        </option>`;

                });

            });

    });

});
</script>
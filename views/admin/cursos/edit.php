<h1>✏️ Editar Curso</h1>

<a href="/Edutech/cursos">⬅ Volver</a>

<br><br>

<form action="/Edutech/cursos/update" method="POST"
      style="max-width:500px; background:rgba(255,255,255,0.05); padding:20px; border-radius:12px;">

    <input type="hidden" name="id" value="<?= $curso['id_curso'] ?>">

    <label>Nombre</label><br>
    <input type="text" name="nombre"
           value="<?= $curso['nombre'] ?>"
           required
           style="width:100%; padding:10px; margin:8px 0;"><br>

    <label>Descripción</label><br>
    <textarea name="descripcion"
              rows="4"
              style="width:100%; padding:10px; margin:8px 0;"><?= $curso['descripcion'] ?></textarea><br>

    <label>Nivel</label><br>
    <select name="nivel" style="width:100%; padding:10px; margin:8px 0;">
        <option value="Basico" <?= $curso['nivel'] == 'Basico' ? 'selected' : '' ?>>Básico</option>
        <option value="Intermedio" <?= $curso['nivel'] == 'Intermedio' ? 'selected' : '' ?>>Intermedio</option>
        <option value="Avanzado" <?= $curso['nivel'] == 'Avanzado' ? 'selected' : '' ?>>Avanzado</option>
    </select><br>

    <label>Estado</label><br>
    <select name="estado" style="width:100%; padding:10px; margin:8px 0;">
        <option value="1" <?= $curso['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
        <option value="0" <?= $curso['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
    </select><br><br>

    <button type="submit"
            style="padding:10px 15px; background:#f59e0b; color:white; border:none; border-radius:8px;">
        Actualizar Curso
    </button>

</form>
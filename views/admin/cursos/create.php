<h1>➕ Nuevo Curso</h1>

<a href="/Edutech/cursos">⬅ Volver</a>

<br><br>

<form action="/Edutech/cursos/store" method="POST"
      style="max-width:500px; background:rgba(255,255,255,0.05); padding:20px; border-radius:12px;">

    <label>Nombre</label><br>
    <input type="text" name="nombre" required
           style="width:100%; padding:10px; margin:8px 0;"><br>

    <label>Descripción</label><br>
    <textarea name="descripcion" rows="4"
              style="width:100%; padding:10px; margin:8px 0;"></textarea><br>

    <label>Nivel</label><br>
    <select name="nivel" style="width:100%; padding:10px; margin:8px 0;">
        <option value="Basico">Básico</option>
        <option value="Intermedio">Intermedio</option>
        <option value="Avanzado">Avanzado</option>
    </select><br>

    <label>Estado</label><br>
    <select name="estado" style="width:100%; padding:10px; margin:8px 0;">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select><br><br>

    <button type="submit"
            style="padding:10px 15px; background:#2563eb; color:white; border:none; border-radius:8px;">
        Guardar Curso
    </button>

</form>
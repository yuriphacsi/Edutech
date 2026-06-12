<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear Usuario - EduTech</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #0f172a;
    color: #e2e8f0;
}

/* CONTENEDOR */
.container {
    padding: 100px 40px 40px;
    display: flex;
    justify-content: center;
}

/* CARD */
.card {
    width: 500px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 25px;
    backdrop-filter: blur(10px);
}

h1 {
    margin-bottom: 20px;
    font-size: 24px;
}

/* INPUTS */
input, select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.2);
    color: white;
    outline: none;
}

input:focus, select:focus {
    border-color: #2563eb;
}

/* BOTÓN */
.btn {
    width: 100%;
    padding: 12px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: #1d4ed8;
}

.back {
    display: inline-block;
    margin-bottom: 15px;
    color: #60a5fa;
    text-decoration: none;
}

.back:hover {
    text-decoration: underline;
}

</style>
</head>

<body>

<div class="container">

    <div class="card">

        <a class="back" href="/Edutech/usuarios">← Volver</a>

        <h1>➕ Crear Usuario</h1>

        <form action="/Edutech/usuarios/store" method="POST">

            <input type="text" name="nombres" placeholder="Nombres" required>

            <input type="text" name="apellidos" placeholder="Apellidos" required>

            <input type="email" name="correo" placeholder="Correo" required>

            <input type="password" name="password" placeholder="Contraseña" required>

            <select name="id_rol" required>
                <option value="">Seleccionar rol</option>
                <option value="1">Admin</option>
                <option value="2">Asesor</option>
                <option value="3">Alumno</option>
            </select>

            <button class="btn" type="submit">Guardar Usuario</button>

        </form>

    </div>

</div>

</body>
</html>
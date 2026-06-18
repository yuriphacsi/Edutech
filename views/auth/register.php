<div class="auth-container">

    <!-- PANEL IZQUIERDO -->
    <div class="auth-brand">

        <img src="/Edutech/public/img/logo.png" alt="EduTech">

        <h1>EduTech</h1>

        <p>
            Únete a nuestra plataforma educativa y accede a cursos,
            tutorías y recursos académicos.
        </p>

    </div>

    <!-- PANEL DERECHO -->
    <div class="login-box">

        <div class="login-header">

            <img src="/Edutech/public/img/logo.png" alt="EduTech">

            <h2>Crear cuenta</h2>

            <p>Registro exclusivo para estudiantes</p>

        </div>

        <?php if (!empty($error)): ?>
            <div class="error">
                ⚠ <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="/Edutech/register" method="POST">

            <input
                type="text"
                name="nombres"
                placeholder="Nombres"
                required
            >

            <input
                type="text"
                name="apellidos"
                placeholder="Apellidos"
                required
            >

            <input
                type="email"
                name="correo"
                placeholder="Correo electrónico"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                required
            >

            <input
                type="password"
                name="confirm_password"
                placeholder="Confirmar contraseña"
                required
            >

            <button
                type="submit"
                id="registerButton">
                Crear cuenta
            </button>

        </form>

        <div class="auth-links">

            <a href="/Edutech/login">
                ¿Ya tienes cuenta? Inicia sesión
            </a>

        </div>

    </div>

    <script>

    const registerForm =
        document.querySelector('form');

    const registerButton =
        document.getElementById('registerButton');

    registerForm.addEventListener('submit', () => {

        registerButton.disabled = true;

        registerButton.textContent =
            'Creando cuenta...';

    });

    </script>

</div>
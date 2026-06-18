<div class="auth-container">

    <!-- PANEL IZQUIERDO -->
    <div class="auth-brand">

        <img src="/Edutech/public/img/logo.png" alt="EduTech">

        <h1>EduTech</h1>

        <p>
            Plataforma educativa moderna para la gestión
            de estudiantes, asesores y cursos.
        </p>

    </div>

    <!-- PANEL DERECHO -->
    <div class="login-box">

        <div class="login-header">

            <img src="/Edutech/public/img/logo.png" alt="EduTech Logo">

            <h2>Iniciar Sesión</h2>

            <p>Accede a tu plataforma educativa</p>

        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                ✅ Cuenta creada correctamente. Ahora puedes iniciar sesión.
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="error">
                ⚠ <?= $error ?>
            </div>
        <?php endif; ?>

        <form
            action="/Edutech/login"
            method="POST"
            class="login-form"
        >

            <input
                type="email"
                name="correo"
                placeholder="Correo electrónico"
                required
            >

            <div class="password-wrapper">

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Contraseña"
                    required
                >

                <span id="togglePassword">
                    👁️
                </span>

            </div>

            <button
                type="submit"
                id="loginButton"
            >
                Ingresar
            </button>

            <div class="auth-links">

                <a href="/Edutech/register">
                    ¿No tienes cuenta? Regístrate
                </a>

            </div>

        </form>

        <a href="/Edutech" class="back-home">
            ← Volver al inicio
        </a>

    </div>

</div>

<script>
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

togglePassword.addEventListener('click', () => {

    const type =
        password.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

    password.setAttribute('type', type);

    togglePassword.textContent =
        type === 'password'
            ? '👁️'
            : '🙈';
});
</script>
<script>

const loginForm =
    document.querySelector('form');

const loginButton =
    document.getElementById('loginButton');

loginForm.addEventListener('submit', () => {

    loginButton.disabled = true;

    loginButton.textContent =
        'Ingresando...';

});

</script>
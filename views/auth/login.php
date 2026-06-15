<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - EduTech</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            width: 320px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background: #2a5298;
            border: none;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-box button:hover {
            background: #1e3c72;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2a5298;
        }
    </style>
</head>
<body>

<div class="login-box">

    <img src="/Edutech/public/img/logo.png" width="120">

    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form action="/Edutech/login" method="POST">

        <input type="email" name="correo" placeholder="Correo" required>

        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Ingresar</button>

    </form>

</div>

</body>
</html>
<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use App\Helpers\Session;
use App\Models\Alumno;

class AuthController extends Controller
{
    public function login()
    {
        Session::start();

        if (Session::has('user')) {

            $rol = Session::get('user')['rol'];

            if ($rol == 1) {
                header("Location: /Edutech/admin");
                exit;
            }

            if ($rol == 2) {
                header("Location: /Edutech/asesor");
                exit;
            }

            if ($rol == 3) {
                header("Location: /Edutech/alumno");
                exit;
            }
        }

        $this->view('auth/login', [], 'layouts/auth');
    }

    public function register()
    {
        $this->view(
            'auth/register',
            [],
            'layouts/auth'
        );
    }

    public function storeRegister()
    {
        $nombres = trim($_POST['nombres'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

            $this->view(
                'auth/register',
                [
                    'error' => 'Correo electrónico inválido'
                ],
                'layouts/auth'
            );

            return;
        }
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $usuarioModel = new Usuario();

        if ($password !== $confirmPassword) {

            $this->view(
                'auth/register',
                [
                    'error' => 'Las contraseñas no coinciden'
                ],
                'layouts/auth'
            );

            return;
        }

        if ($usuarioModel->findByEmail($correo)) {

            $this->view(
                'auth/register',
                [
                    'error' => 'El correo ya está registrado'
                ],
                'layouts/auth'
            );

            return;
        }

        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $idUsuario = $usuarioModel->create([
            'id_rol' => 3,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'correo' => $correo,
            'password' => $passwordHash,
            'estado' => 1
        ]);

        $alumnoModel = new Alumno();

        $alumnoModel->create([
            'id_usuario' => $idUsuario,
            'codigo_estudiante' => null,
            'institucion' => null,
            'carrera' => null,
            'ciclo' => null
        ]);

        header("Location: /Edutech/login?success=1");
        exit;
    }

    public function authenticate()
    {
        Session::start();

        $correo = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuarioModel = new Usuario();
        $user = $usuarioModel->findByEmail($correo);

        if (!$user) {
            $this->view('auth/login', [
                'error' => 'Correo o contraseña incorrectos'
            ], 'layouts/auth');
            return;
        }

        if ((int)$user['estado'] === 0) {
            $this->view('auth/login', [
                'error' => 'Tu cuenta está inactiva. Contacta al administrador.'
            ], 'layouts/auth');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            $this->view('auth/login', [
                'error' => 'Correo o contraseña incorrectos'
            ], 'layouts/auth');
            return;
        }

        Session::set('user', [
            'id' => $user['id'],
            'nombres' => $user['nombres'],
            'apellidos' => $user['apellidos'],
            'rol' => $user['id_rol']
        ]);

        $rol = $user['id_rol'];

        if ($rol == 1) {
            header("Location: /Edutech/admin");
        } elseif ($rol == 2) {
            header("Location: /Edutech/asesor");
        } else {
            header("Location: /Edutech/alumno");
        }

        exit;
    }

    public function logout()
    {
        Session::start();
        $_SESSION = [];
        session_unset();
        session_destroy();

        header("Location: /Edutech/login");
        exit;
    }
}
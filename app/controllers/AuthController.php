<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use App\Helpers\Session;

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

    public function authenticate()
    {
        Session::start();

        $correo = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuarioModel = new Usuario();
        $user = $usuarioModel->findByEmail($correo);

        if (!$user) {
            die("Usuario no existe");
        }

        if (!password_verify($password, $user['password'])) {
            die("Contraseña incorrecta");
        }

        Session::set('user', [
            'id' => $user['id_usuario'],
            'rol' => (int)$user['id_rol']
        ]);

        switch ((int)$user['id_rol']) {
            case 1:
                header("Location: /Edutech/admin");
                break;

            case 2:
                header("Location: /Edutech/asesor");
                break;

            case 3:
                header("Location: /Edutech/alumno");
                break;

            default:
                die("Rol no válido");
        }

        exit;
    }

    public function logout()
    {
        Session::start();

        $_SESSION = [];
        session_destroy();

        header("Location: /Edutech/login");
        exit;
    }
}
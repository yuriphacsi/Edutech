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

        if (isset($_SESSION['user'])) {

            $rol = $_SESSION['user']['rol'];

            switch ($rol) {
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

        if ($password !== $user['password']) {
            die("Contraseña incorrecta");
        }

        // 🔥 SISTEMA LIMPIO
        Session::set('user', [
            'id' => $user['id_usuario'],
            'rol' => $user['id_rol']
        ]);

        $rol = (int) $user['id_rol']; // 👈 fuerza entero

        switch ($rol) {
            case 1:
                $redirect = "/Edutech/admin";
                break;

            case 2:
                $redirect = "/Edutech/asesor";
                break;

            case 3:
                $redirect = "/Edutech/alumno";
                break;

            default:
                die("Rol no válido: " . $rol);
        }
        
        header("Location: $redirect");
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
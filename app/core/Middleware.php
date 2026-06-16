<?php

namespace App\Core;

class Middleware
{
    public static function auth()
    {
        if (!isset(Session::get('user'))) {
            header("Location: /Edutech/login");
            exit;
        }
    }

    public static function role($role)
    {
        if (!isset(Session::get('user'))) {
            header("Location: /Edutech/login");
            exit;
        }

        if (!isset(Session::get('user')['rol'])) {
            die("Rol no definido");
        }

        if (Session::get('user')['rol'] !== $role) {
            die("Acceso denegado");
        }
    }
}
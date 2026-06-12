<?php

namespace App\Core;

class Middleware
{
    public static function auth()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /Edutech/login");
            exit;
        }
    }

    public static function role($role)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /Edutech/login");
            exit;
        }

        if (!isset($_SESSION['user']['rol'])) {
            die("Rol no definido");
        }

        if ($_SESSION['user']['rol'] !== $role) {
            die("Acceso denegado");
        }
    }
}
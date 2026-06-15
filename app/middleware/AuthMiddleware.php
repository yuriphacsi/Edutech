<?php

namespace App\Middleware;

use App\Helpers\Session;

class AuthMiddleware
{
    public static function check()
    {
        Session::start();

        if (!isset($_SESSION['user'])) {
            header("Location: /Edutech/login");
            exit;
        }
    }

    public static function role(array $roles)
    {
        Session::start();

        if (!isset($_SESSION['user'])) {
            header("Location: /Edutech/login");
            exit;
        }

        $userRole = (int) $_SESSION['user']['rol'];

        if (!in_array($userRole, $roles)) {
            die("Acceso denegado");
        }
    }
}
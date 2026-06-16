<?php

namespace App\Middleware;

use App\Helpers\Session;

class AuthMiddleware
{
    public static function check()
    {
        Session::start();

        if (!isset(Session::get('user'))) {
            header("Location: /Edutech/login");
            exit;
        }
    }

    public static function role(array $roles)
    {
        Session::start();

        if (!isset(Session::get('user'))) {
            header("Location: /Edutech/login");
            exit;
        }

        $userRole = (int) Session::get('user')['rol'];

        if (!in_array($userRole, $roles)) {
            die("Acceso denegado");
        }
    }
}
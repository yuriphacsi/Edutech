<?php

namespace App\Middleware;

use App\Models\Permiso;

class PermissionMiddleware
{
    public static function check(string $permiso): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            header("Location: /Edutech/login");
            exit;
        }

        $permisoModel = new Permiso();
        $permisos = $permisoModel->getByRole($user['rol']);

        if (!in_array($permiso, $permisos)) {
            die("⛔ No tienes permiso para acceder a esto");
        }
    }
}
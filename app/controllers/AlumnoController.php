<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        // Toma id_usuario directo de sesión con fallback seguro
        $id_usuario = (int) ($_SESSION['user']['id'] ?? 0);

        $alumnoModel = new Alumno();

        // Si no hay id válido, muestra dashboard vacío sin error
        $cursos = $id_usuario > 0
            ? $alumnoModel->getCursosInscritos($id_usuario)
            : [];

        $this->view('alumno/dashboard', [
            'module' => 'alumnos',
            'cursos' => $cursos,
        ], 'layouts/main');
    }
}
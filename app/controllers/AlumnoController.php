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

        $id_usuario = (int) ($_SESSION['user']['id'] ?? 0);

        $alumnoModel = new Alumno();

        // MIS CURSOS
        $misCursos = $id_usuario > 0
            ? $alumnoModel->getCursosInscritos($id_usuario)
            : [];

        // CURSOS DISPONIBLES
        $cursosDisponibles = $id_usuario > 0
            ? $alumnoModel->getCursosDisponibles($id_usuario)
            : [];

        $this->view('alumno/dashboard', [
            'module' => 'alumnos',
            'misCursos' => $misCursos,
            'cursosDisponibles' => $cursosDisponibles
        ], 'layouts/main');
    }

    public function inscribirse()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        $id_usuario = (int) ($_SESSION['user']['id'] ?? 0);
        $curso_id = (int) ($_POST['curso_id'] ?? 0);

        if ($id_usuario <= 0 || $curso_id <= 0) {
            header("Location: /Edutech/alumno");
            exit;
        }

        $alumnoModel = new Alumno();

        $ok = $alumnoModel->inscribir($id_usuario, $curso_id);

        header("Location: /Edutech/alumno");
        exit;
    }
}
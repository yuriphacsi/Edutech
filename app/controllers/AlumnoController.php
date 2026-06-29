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

        $id_usuario  = (int) ($_SESSION['user']['id'] ?? 0);
        $alumnoModel = new Alumno();

        $misCursos = $id_usuario > 0
            ? $alumnoModel->getCursosInscritos($id_usuario)
            : [];

        $cursosDisponibles = $id_usuario > 0
            ? $alumnoModel->getCursosDisponibles($id_usuario)
            : [];

        $this->view('alumno/dashboard', [
            'module'            => 'alumnos',
            'misCursos'         => $misCursos,
            'cursosDisponibles' => $cursosDisponibles
        ], 'layouts/main');
    }

    public function cursos()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        $id_usuario  = (int) ($_SESSION['user']['id'] ?? 0);
        $alumnoModel = new Alumno();

        $misCursos = $id_usuario > 0
            ? $alumnoModel->getCursosInscritos($id_usuario)
            : [];

        $this->view('alumno/cursos', [
            'module'    => 'mis-cursos',
            'misCursos' => $misCursos,
        ], 'layouts/main');
    }

    public function inscribirse()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        $id_usuario = (int) ($_SESSION['user']['id'] ?? 0);
        $curso_id   = (int) ($_POST['curso_id'] ?? 0);

        if ($id_usuario <= 0 || $curso_id <= 0) {
            header("Location: /Edutech/alumno");
            exit;
        }

        $inscripcion = new \App\Models\Inscripcion();

        // evitar duplicados
        if ($inscripcion->existsUsuarioCurso($id_usuario, $curso_id)) {
            header("Location: /Edutech/alumno");
            exit;
        }

        $inscripcion->inscribir($id_usuario, $curso_id);

        header("Location: /Edutech/alumno");
        exit;
    }

    public function anular()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        $id_usuario = (int) ($_SESSION['user']['id'] ?? 0);
        $curso_id   = (int) ($_POST['curso_id'] ?? 0);

        if ($id_usuario > 0 && $curso_id > 0) {
            $alumnoModel = new Alumno();
            $alumnoModel->anular($id_usuario, $curso_id);
        }

        header("Location: /Edutech/mis-cursos");
        exit;
    }
}
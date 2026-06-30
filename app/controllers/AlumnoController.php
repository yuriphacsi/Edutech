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

    public function notas()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        $id_usuario  = (int) ($_SESSION['user']['id'] ?? 0);
        $alumnoModel = new Alumno();

        $notasPorCurso = $id_usuario > 0
            ? $alumnoModel->getNotasPorCurso($id_usuario)
            : [];

        $id_alumno = $id_usuario > 0
            ? $alumnoModel->getIdAlumnoPorUsuario($id_usuario)
            : null;

        $calificacionesAsesorias = $id_alumno
            ? $alumnoModel->getCalificacionesAsesorias($id_alumno)
            : [];

        $this->view('alumno/notas', [
            'module'                  => 'mis-notas',
            'notasPorCurso'           => $notasPorCurso,
            'calificacionesAsesorias' => $calificacionesAsesorias,
        ], 'layouts/main');
    }

    public function asistencia()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]);

        $id_usuario  = (int) ($_SESSION['user']['id'] ?? 0);
        $alumnoModel = new Alumno();

        $id_alumno = $id_usuario > 0
            ? $alumnoModel->getIdAlumnoPorUsuario($id_usuario)
            : null;

        $asistencias = $id_alumno
            ? $alumnoModel->getAsistenciaPorCurso($id_alumno)
            : [];

        $resumen = $id_alumno
            ? $alumnoModel->getResumenAsistencia($id_alumno)
            : ['total' => 0, 'asistio' => 0, 'programada' => 0, 'falta' => 0, 'cancelada' => 0, 'porcentaje' => 0];

        $this->view('alumno/asistencia', [
            'module'      => 'mis-asistencia',
            'asistencias' => $asistencias,
            'resumen'     => $resumen,
        ], 'layouts/main');
    }
}
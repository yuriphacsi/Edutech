<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Certificado;
use App\Helpers\Session;
use App\Middleware\AuthMiddleware;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Asesor;
use App\Models\Inscripcion;

class CertificadoController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]);
    }

    public function index()
    {
        $certificado = new Certificado();

        $this->view('admin/certificados/index', [
            'module' => 'certificados',
            'certificados' => $certificado->getAll()
        ], 'layouts/main');
    }

    public function create()
    {
        $alumnoModel = new Alumno();
        $cursoModel = new Curso();
        $asesorModel = new Asesor();

        $this->view('admin/certificados/create', [
            'alumnos' => $alumnoModel->getAllAlumnos(),
            'cursos' => $cursoModel->all(),
            'asesores' => $asesorModel->getAllAsesores(),
            'module' => 'certificados'
        ], 'layouts/main');
    }

    public function store()
    {
        Session::start();

        $cert = new \App\Models\Certificado();
        $inscripcion = new \App\Models\Inscripcion();

        $id_alumno = $_POST['id_alumno'] ?? null;
        $id_curso = $_POST['id_curso'] ?? null;
        $id_asesor = $_POST['id_asesor'] ?? null;

        $descripcion = $_POST['descripcion'] ?? '';
        $horas = $_POST['horas'] ?? 0;

        if (!$id_alumno || !$id_curso) {
            Session::set('error', 'Datos incompletos');
            header("Location: /Edutech/admin/certificados/create");
            exit;
        }

        if (!$inscripcion->existsAlumnoCurso($id_alumno, $id_curso)) {
            Session::set('error', 'El alumno no está inscrito en este curso');
            header("Location: /Edutech/admin/certificados/create");
            exit;
        }

        $codigo = 'CERT-' . date('Y') . '-' . rand(10000, 99999);

        $cert->create([
            'id_alumno' => $id_alumno,
            'id_curso' => $id_curso,
            'id_asesor' => $id_asesor,
            'codigo' => $codigo,
            'descripcion' => $descripcion,
            'horas' => $horas,
            'fecha_emision' => date('Y-m-d'),
            'estado' => 1
        ]);

        Session::set('success', 'Certificado emitido correctamente');

        header("Location: /Edutech/admin/certificados");
        exit;
    }

    public function edit(){}

    public function update(){}

    public function delete(){}

    public function show(){}

    public function download(){}
}
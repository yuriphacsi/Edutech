<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Curso;
use App\Models\Asesor;
use App\Middleware\AuthMiddleware;

class CursoController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]); // solo admin
    }

    public function index()
    {
        $cursoModel = new Curso();
        $cursos = $cursoModel->all();

        $this->view('admin/cursos/index', [
            'cursos' => $cursos
        ]);
    }

    public function create()
    {
        $asesorModel = new Asesor();

        $this->view('admin/cursos/create', [
            'asesores' => $asesorModel->all()
        ], 'layouts/main');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Método no permitido");
        }

        $cursoModel = new Curso();

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'nivel' => $_POST['nivel'] ?? 'Basico',
            'cupo_maximo' => (int) ($_POST['cupo_maximo'] ?? 30),
            'id_asesor' => !empty($_POST['id_asesor']) ? (int)$_POST['id_asesor'] : null,
            'estado' => (int) ($_POST['estado'] ?? 1)
        ];

        if (trim($data['nombre']) === '') {
            die("El nombre es obligatorio");
        }

        $cursoModel->create($data);

        header("Location: /Edutech/admin/cursos");
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID no válido");
        }

        $cursoModel = new Curso();
        $asesorModel = new Asesor();

        $this->view('admin/cursos/edit', [
            'curso' => $cursoModel->find($id),
            'asesores' => $asesorModel->all()
        ], 'layouts/main');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Método no permitido");
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $cursoModel = new Curso();

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'nivel' => $_POST['nivel'] ?? 'Basico',
            'cupo_maximo' => (int) ($_POST['cupo_maximo'] ?? 30),
            'id_asesor' => !empty($_POST['id_asesor']) ? (int)$_POST['id_asesor'] : null,
            'estado' => (int) ($_POST['estado'] ?? 1)
        ];

        $cursoModel->update($id, $data);

        header("Location: /Edutech/admin/cursos");
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Método no permitido");
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $cursoModel = new Curso();

        $cursoModel->update($id, [
            'estado' => 0
        ]);

        header("Location: /Edutech/admin/cursos");
        exit;
    }
}
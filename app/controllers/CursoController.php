<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Curso;

class CursoController extends Controller
{
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
        $this->view('admin/cursos/create');
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
            'estado' => (int) ($_POST['estado'] ?? 1)
        ];

        if ($data['nombre'] === '') {
            die("El nombre es obligatorio");
        }

        $cursoModel->create($data);

        header("Location: /Edutech/cursos");
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID no válido");
        }

        $cursoModel = new Curso();
        $curso = $cursoModel->find($id);

        $this->view('admin/cursos/edit', [
            'curso' => $curso
        ]);
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
            'estado' => (int) ($_POST['estado'] ?? 1)
        ];

        $cursoModel->update($id, $data);

        header("Location: /Edutech/cursos");
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
        $cursoModel->delete((int)$id);

        header("Location: /Edutech/cursos");
        exit;
    }
}
<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Curso;
use App\Models\Asesor;
use App\Helpers\Session;
use App\Middleware\AuthMiddleware;

class CursoController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]); // solo admin
    }

    // 📄 LISTAR CURSOS
    public function index()
    {
        $cursoModel = new Curso();

        $data = [
            'cursos' => $cursoModel->listWithAlumnos(),
        ];

        $this->view('admin/cursos/index', [
            'cursos' => $cursoModel->listWithAlumnos(),
            'module' => 'cursos'
        ], 'layouts/main');
    }

    // ➕ FORM CREAR
    public function create()
    {
        $asesorModel = new Asesor();

        $data = [
            'asesores' => $asesorModel->getAllAsesores()
        ];

        $this->view('admin/cursos/create', [
            'asesores' => $asesorModel->getAllAsesores(),
            'module' => 'cursos'
        ], 'layouts/main');
    }

    // 💾 GUARDAR CURSO
    public function store()
    {
        Session::start();

        $curso = new Curso();

        $nombre = $_POST['nombre'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
        $nivel = $_POST['nivel'] ?? null;
        $id_asesor = !empty($_POST['id_asesor']) ? $_POST['id_asesor'] : null;
        $cupo_maximo = $_POST['cupo_maximo'] ?? 0;

        // 📸 imagen (simple base)
        $imagen = null;

        if (!empty($_FILES['imagen']['name'])) {
            $imageName = time() . '_' . $_FILES['imagen']['name'];
            $path = "public/uploads/" . $imageName;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $path);

            $imagen = $imageName;
        }

        // 💾 guardar
        $curso->create([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'nivel' => $nivel,
            'id_asesor' => $id_asesor,
            'cupo_maximo' => $cupo_maximo,
            'imagen' => $imagen,
            'estado' => 1
        ]);

        Session::set('success', '✔ Curso creado correctamente');

        header("Location: /Edutech/admin/cursos");
        exit;
    }

    // ✏️ EDITAR
    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $curso = new Curso();
        $asesor = new Asesor();

        $cursoData = $curso->find($id);

        $this->view('admin/cursos/edit', [
            'curso' => $cursoData,
            'asesores' => $asesor->getAllAsesores(),
            'module' => 'cursos'
        ], 'layouts/main');
    }

    // 🔄 ACTUALIZAR
    public function update()
    {
        $id = $_POST['id_curso'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $curso = new Curso();

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'nivel' => $_POST['nivel'],
            'id_asesor' => !empty($_POST['id_asesor']) ? $_POST['id_asesor'] : null,
            'cupo_maximo' => $_POST['cupo_maximo'] ?? 0
        ];

        if (!empty($_FILES['imagen']['name'])) {
            $imageName = time() . '_' . $_FILES['imagen']['name'];
            $path = "public/uploads/" . $imageName;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $path);

            $data['imagen'] = $imageName;
        }

        $curso->update($id, $data);

        Session::set('success', '✔ Curso actualizado correctamente');

        header("Location: /Edutech/admin/cursos");
        exit;
    }

    // 🗑️ ELIMINAR
    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $curso = new Curso();
        $curso->delete($id);

        Session::set('success', '✔ Curso eliminado');

        header("Location: /Edutech/admin/cursos");
        exit;
    }

    public function alumnos()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $curso = new \App\Models\Curso();
        $alumnos = $curso->getAlumnosByCurso((int)$id);

        $this->view('admin/cursos/alumnos', [
            'alumnos' => $alumnos,
            'module' => 'cursos'
        ], 'layouts/main');
    }
}
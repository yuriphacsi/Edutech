<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Libro;
use App\Helpers\Session;
use App\Middleware\AuthMiddleware;

class BibliotecaController extends Controller
{
    public function __construct()
    {
        // Acceso permitido a Administrador (1), Asesor (2) y Alumno (3)
        AuthMiddleware::check();
        AuthMiddleware::role([1, 2, 3]);
    }

    // 📄 LISTAR LIBROS (catalogo + buscador)
    public function index()
    {
        $libroModel = new Libro();

        $busqueda = $_GET['q'] ?? '';

        if (!empty($busqueda)) {
            $libros = $libroModel->buscar($busqueda);
        } else {
            $libros = $libroModel->listActivos();
        }

        $rol = (int) ($_SESSION['user']['rol'] ?? 0);

        $this->view('admin/biblioteca/index', [
            'libros' => $libros,
            'busqueda' => $busqueda,
            'rol' => $rol,
            'module' => 'biblioteca'
        ], 'layouts/main');
    }

    // 👁️ VER DETALLE DE UN LIBRO
    public function show()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $libroModel = new Libro();
        $libro = $libroModel->find((int) $id);

        if (!$libro) {
            die("Libro no encontrado");
        }

        $rol = (int) ($_SESSION['user']['rol'] ?? 0);

        $this->view('admin/biblioteca/show', [
            'libro' => $libro,
            'rol' => $rol,
            'module' => 'biblioteca'
        ], 'layouts/main');
    }

    // ➕ FORM CREAR (solo admin)
    public function create()
    {
        AuthMiddleware::role([1]);

        $this->view('admin/biblioteca/create', [
            'module' => 'biblioteca'
        ], 'layouts/main');
    }

    // 💾 GUARDAR LIBRO (solo admin)
    public function store()
    {
        AuthMiddleware::role([1]);
        Session::start();

        $libroModel = new Libro();

        $portada = null;

        if (!empty($_FILES['portada']['name'])) {
            $imageName = time() . '_' . $_FILES['portada']['name'];
            $path = "public/uploads/" . $imageName;

            move_uploaded_file($_FILES['portada']['tmp_name'], $path);

            $portada = $imageName;
        }

        $archivoPdf = null;

        if (!empty($_FILES['archivo_pdf']['name'])) {
            $pdfName = time() . '_' . $_FILES['archivo_pdf']['name'];
            $pathPdf = "public/uploads/" . $pdfName;

            move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $pathPdf);

            $archivoPdf = $pdfName;
        }

        $libroModel->create([
            'titulo' => $_POST['titulo'] ?? '',
            'autor' => $_POST['autor'] ?? '',
            'categoria' => $_POST['categoria'] ?? null,
            'descripcion' => $_POST['descripcion'] ?? null,
            'portada' => $portada,
            'archivo_pdf' => $archivoPdf,
            'enlace' => $_POST['enlace'] ?? null,
            'estado' => 1
        ]);

        Session::set('success', '✔ Libro agregado correctamente');

        header("Location: /Edutech/admin/biblioteca");
        exit;
    }

    // ✏️ FORM EDITAR (solo admin)
    public function edit()
    {
        AuthMiddleware::role([1]);

        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $libroModel = new Libro();
        $libro = $libroModel->find((int) $id);

        $this->view('admin/biblioteca/edit', [
            'libro' => $libro,
            'module' => 'biblioteca'
        ], 'layouts/main');
    }

    // 🔄 ACTUALIZAR (solo admin)
    public function update()
    {
        AuthMiddleware::role([1]);
        Session::start();

        $id = $_POST['id_biblioteca'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $libroModel = new Libro();

        $data = [
            'titulo' => $_POST['titulo'] ?? '',
            'autor' => $_POST['autor'] ?? '',
            'categoria' => $_POST['categoria'] ?? null,
            'descripcion' => $_POST['descripcion'] ?? null,
            'enlace' => $_POST['enlace'] ?? null,
        ];

        if (!empty($_FILES['portada']['name'])) {
            $imageName = time() . '_' . $_FILES['portada']['name'];
            $path = "public/uploads/" . $imageName;

            move_uploaded_file($_FILES['portada']['tmp_name'], $path);

            $data['portada'] = $imageName;
        }

        if (!empty($_FILES['archivo_pdf']['name'])) {
            $pdfName = time() . '_' . $_FILES['archivo_pdf']['name'];
            $pathPdf = "public/uploads/" . $pdfName;

            move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $pathPdf);

            $data['archivo_pdf'] = $pdfName;
        }

        $libroModel->update((int) $id, $data);

        Session::set('success', '✔ Libro actualizado correctamente');

        header("Location: /Edutech/admin/biblioteca");
        exit;
    }

    // 🗑️ ELIMINAR (solo admin)
    public function delete()
    {
        AuthMiddleware::role([1]);
        Session::start();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID inválido");
        }

        $libroModel = new Libro();
        $libroModel->delete((int) $id);

        Session::set('success', '✔ Libro eliminado');

        header("Location: /Edutech/admin/biblioteca");
        exit;
    }
}

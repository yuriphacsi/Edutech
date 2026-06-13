<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use App\Middleware\AuthMiddleware;

class UsuarioController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]);

        $usuario = new \App\Models\Usuario();

        $data = [
            'usuarios' => $usuario->all()
        ];

        $this->view('admin/usuarios/index', $data, 'layouts/main');
    }

    public function create()
    {
        AuthMiddleware::check();
        AuthMiddleware::role(1);

        $this->view('admin/usuarios/create', [], 'layouts/main');
    }

    public function store()
    {
        AuthMiddleware::check();
        AuthMiddleware::role(1);

        $usuario = new \App\Models\Usuario();

        $usuario->create([
            'id_rol' => $_POST['id_rol'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'correo' => $_POST['correo'],
            'password' => $_POST['password'],
            'estado' => 1
        ]);

        header("Location: /Edutech/usuarios");
        exit;
    }

    public function edit()
    {
        AuthMiddleware::check();
        AuthMiddleware::role(1);

        $id = $_GET['id'];

        $usuario = new \App\Models\Usuario();

        $data = [
            'usuario' => $usuario->find($id)
        ];

        $this->view('admin/usuarios/edit', $data, 'layouts/main');
    }

    public function update()
    {
        AuthMiddleware::check();
        AuthMiddleware::role(1);

        $id = $_POST['id_usuario'];

        $usuario = new \App\Models\Usuario();

        $usuario->update($id, [
            'id_rol' => $_POST['id_rol'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'correo' => $_POST['correo']
        ]);

        header("Location: /Edutech/usuarios");
        exit;
    }

   public function delete()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]);

        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID no enviado");
        }

        $model = new \App\Models\Usuario();
        $usuario = $model->find($id);

        if (!$usuario) {
            die("Usuario no encontrado");
        }

        // 🔒 PROTECCIÓN: NO eliminar admin
        if ($usuario['id_rol'] == 1) {
            die("No se puede eliminar el usuario administrador");
        }

        $model->delete($id);

        header("Location: /Edutech/usuarios");
        exit;
    }

    public function toggle()
    {
        AuthMiddleware::check();
        AuthMiddleware::role(1);

        $id = $_GET['id'];

        $usuario = new \App\Models\Usuario();

        $data = $usuario->find($id);

        $nuevoEstado = $data['estado'] == 1 ? 0 : 1;

        $usuario->update($id, [
            'estado' => $nuevoEstado
        ]);

        header("Location: /Edutech/usuarios");
        exit;
    }
}
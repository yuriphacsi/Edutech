<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Asesor;
use App\Middleware\AuthMiddleware;
use App\Helpers\Session;

class UsuarioController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]);
    }

    public function index()
    {
        $usuarioModel = new Usuario();

        $q = $_GET['q'] ?? null;

        $stats = $usuarioModel->getStats();

        $usuarios = $q
            ? $usuarioModel->search($q)
            : $usuarioModel->all();

        $this->view('admin/usuarios/index', [
            'usuarios' => $usuarios,
            'stats' => $stats,
            'q' => $q,
            'module' => 'usuarios'
        ], 'layouts/main');
    }

    public function create()
    {
        $this->view('admin/usuarios/create', [], 'layouts/main');
    }

    public function store()
    {
        Session::start();

        $usuario = new Usuario();

        $correo = $_POST['correo'] ?? null;

        if (!$correo) {
            Session::set('error', '❌ Correo inválido');
            header("Location: /Edutech/admin/usuarios/create");
            exit;
        }

        if ($usuario->emailExists($correo)) {
            Session::set('error', '❌ Este correo ya está registrado');
            header("Location: /Edutech/admin/usuarios/create");
            exit;
        }

        $id = $usuario->create([
            'id_rol' => $_POST['id_rol'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'correo' => $correo,
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'estado' => 1
        ]);

        if ($_POST['id_rol'] == 2) {
            $asesor = new Asesor();
            $asesor->createAsesor($id);
        }

        if ($_POST['id_rol'] == 3) {
            $alumno = new Alumno();
            $alumno->create([
                'id_usuario' => $id
            ]);
        }

        Session::set('success', '✔ Usuario creado correctamente');

        header("Location: /Edutech/admin/usuarios");
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID no válido");
        }

        $usuarioModel = new Usuario();

        $this->view('admin/usuarios/edit', [
            'usuario' => $usuarioModel->find($id)
        ], 'layouts/main');
    }

    public function update()
    {
        $id = $_POST['id_usuario'] ?? null;

        if (!$id) {
            die("ID no válido");
        }

        $usuario = new Usuario();

        $usuario->update($id, [
            'id_rol' => $_POST['id_rol'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'correo' => $_POST['correo']
        ]);

        header("Location: /Edutech/admin/usuarios");
        exit;
    }

    public function delete()
    {
        Session::start();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID no enviado");
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            die("Usuario no encontrado");
        }

        if ((int)$usuario['id_rol'] === 1) {
            die("No se puede eliminar un administrador");
        }

        $sessionUserId = $_SESSION['user']['id'] ?? null;

        if ($usuario['id_usuario'] == $sessionUserId) {
            die("No puedes eliminar tu propia cuenta");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Método no permitido");
        }

        $this->logDeletion($usuario);
        $usuarioModel->delete($id);

        header("Location: /Edutech/admin/usuarios");
        exit;
    }

    public function toggle()
    {
        Session::start();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID no enviado");
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            die("Usuario no encontrado");
        }

        if ((int)$usuario['id_rol'] === 1) {
            die("No se puede cambiar el estado de un administrador");
        }

        $nuevoEstado = $usuario['estado'] == 1 ? 0 : 1;

        $usuarioModel->update($id, [
            'estado' => $nuevoEstado
        ]);

        header("Location: /Edutech/admin/usuarios");
        exit;
    }

    private function logDeletion($usuario)
    {
        $usuarioModel = new Usuario();
        $db = $usuarioModel->getConnection();

        $adminId = $_SESSION['user']['id'] ?? null;

        if (!$adminId) {
            return;
        }

        $deletedId = $usuario['id_usuario'] ?? null;

        if (!$deletedId) {
            return;
        }

        try {
            $stmt = $db->prepare("
                INSERT INTO logs_usuarios (id_usuario, accion, data)
                VALUES (:id_usuario, :accion, :data)
            ");

            $stmt->execute([
                'id_usuario' => $adminId,
                'accion' => 'DELETE_USER',
                'data' => json_encode([
                    'deleted_user_id' => $deletedId,
                    'email' => $usuario['correo'] ?? null,
                    'time' => date('Y-m-d H:i:s')
                ])
            ]);

        } catch (\Throwable $e) {
            // silencioso
        }
    }
}
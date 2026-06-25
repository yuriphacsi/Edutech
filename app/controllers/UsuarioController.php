<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;
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

        if ($q) {
            $usuarios = $usuarioModel->search($q);
        } else {
            $usuarios = $usuarioModel->all();
        }

        $stats = $usuarioModel->getStats();
        $usuarios = $q ? $usuarioModel->search($q) : $usuarioModel->all();

        $data = [
            'usuarios' => $usuarios,
            'stats' => $stats,
            'q' => $q
        ];

        $this->view('admin/usuarios/index', $data, 'layouts/main');
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

        // 🔥 validar duplicado
        if ($usuario->emailExists($correo)) {
            Session::set('error', '❌ Este correo ya está registrado');
            header("Location: /Edutech/admin/usuarios/create");
            exit;
        }

        // crear usuario
        $id = $usuario->create([
            'id_rol' => $_POST['id_rol'],
            'nombres' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'correo' => $correo,
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'estado' => 1
        ]);

        $db = $usuario->getConnection();

        // 👨‍🏫 asesor
        if ($_POST['id_rol'] == 2) {
            $db->prepare("INSERT INTO asesores (id_usuario) VALUES (:id)")
                ->execute(['id' => $id]);
        }

        // 👨‍🎓 alumno
        if ($_POST['id_rol'] == 3) {
            $db->prepare("INSERT INTO alumnos (id_usuario) VALUES (:id)")
                ->execute(['id' => $id]);
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

        $data = [
            'usuario' => $usuarioModel->find($id)
        ];

        $this->view('admin/usuarios/edit', $data, 'layouts/main');
    }

    public function update()
    {
        $id = $_POST['id_usuario'];

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
        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID no enviado");
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            die("Usuario no encontrado");
        }

        // 🚨 PROTECCIÓN 1: evitar admin
        if ((int)$usuario['id_rol'] === 1) {
            die("No se puede eliminar un administrador");
        }

        // 🚨 PROTECCIÓN 2: evitar auto-eliminación
        if ($usuario['id_usuario'] == $_SESSION['user']['id_usuario']) {
            die("No puedes eliminar tu propia cuenta");
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Método no permitido");
        }

        // ✔ eliminar
        $this->logDeletion($usuario);
        $usuarioModel->delete($id);

        header("Location: /Edutech/admin/usuarios");
        exit;
    }

    public function toggle()
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            die("ID no enviado");
        }

        $usuarioModel = new Usuario();

        $usuario = $usuarioModel->find($id);

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

        // 🚨 validar sesión correctamente
        $adminId = $_SESSION['user']['id_usuario'] ?? null;

        if (!$adminId) {
            return; // no rompe el sistema
        }

        // 🚨 evitar null en usuario eliminado
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
            // 🔥 nunca romper flujo por logs
        }
    }
}
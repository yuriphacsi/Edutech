<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Usuario;
use App\Models\Curso;

class AdminController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]); // 👈 solo admin

        $usuario = new Usuario();
        $curso = new Curso();

        $data = [
            'totalUsuarios' => $usuario->countAll(),
            'totalCursos' => $curso->countAll(),
        ];

        $this->view('admin/dashboard', $data, 'layouts/main');
    }
}
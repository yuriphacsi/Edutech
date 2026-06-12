<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;

class AlumnoController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([3]); // 👈 solo alumnos

        $this->view('alumno/dashboard', [], 'layouts/main');
    }
}
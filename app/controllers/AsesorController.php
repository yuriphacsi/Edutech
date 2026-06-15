<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;

class AsesorController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([2]); // 👈 solo asesores

        $this->view('asesor/dashboard', [], 'layouts/main');
    }
}
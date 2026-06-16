<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', [], 'layouts/public');
    }

    public function admin()
    {
        $this->view('admin/dashboard', [], 'layouts/main');
    }

    public function asesor()
    {
        $this->view('asesor/dashboard', [], 'layouts/main');
    }

    public function alumno()
    {
        $this->view('alumno/dashboard', [], 'layouts/main');
    }
}
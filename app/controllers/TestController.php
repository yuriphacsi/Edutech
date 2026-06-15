<?php

namespace App\Controllers;

use App\Models\Rol;

class TestController
{
    public function index()
    {
        $rol = new Rol();

        // Probar INSERT
        $rol->create([
            'nombre' => 'Administrador'
        ]);

        // Probar SELECT ALL
        $roles = $rol->all();

        echo "<pre>";
        print_r($roles);
        echo "</pre>";
    }
}
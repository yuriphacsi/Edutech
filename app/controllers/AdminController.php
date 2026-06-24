<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Usuario;
use App\Models\Curso;
use App\Middleware\PermissionMiddleware;

class AdminController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();
        AuthMiddleware::role([1]);

        PermissionMiddleware::check('ver_dashboard');

        $usuario = new Usuario();
        $curso = new Curso();

        // =========================
        // 📊 KPIs BASE
        // =========================
        $totalUsuarios = $usuario->countAll();
        $usuariosActivos = $usuario->countByStatus(1);
        $usuariosInactivos = $usuario->countByStatus(0);
        $totalCursos = $curso->countAll();

        // =========================
        // 📈 MÉTRICAS (SEGURAS)
        // =========================
        $crecimientoUsuarios = $this->calcularCrecimiento(
            $usuariosActivos,
            $totalUsuarios
        );

        // =========================
        // 📊 ANALYTICS (NIVEL 3)
        // =========================
        $usuariosUltimos12Meses = $usuario->usersLast12Months() ?? [];
        $ultimosUsuarios = $usuario->getLatest(5) ?? [];
        $cursosRecientes = $curso->getLatest(5) ?? [];

        // =========================
        // 📦 DATA FINAL
        // =========================
        $data = [
            // KPIs
            'totalUsuarios' => $totalUsuarios,
            'usuariosActivos' => $usuariosActivos,
            'usuariosInactivos' => $usuariosInactivos,
            'totalCursos' => $totalCursos,

            // KPI extra
            'crecimientoUsuarios' => $crecimientoUsuarios,

            // gráficos
            'usuariosUltimos12Meses' => $usuariosUltimos12Meses,

            // feed / actividad
            'ultimosUsuarios' => $ultimosUsuarios,
            'ultimosAccesos' => $usuario->getLastLogins(5),
            'cursosRecientes' => $cursosRecientes,
        ];

        $this->view('admin/dashboard', $data, 'layouts/main');
    }


    private function calcularCrecimiento($activos, $total): float
    {
        if ($total <= 0) return 0;

        return round(($activos / $total) * 100, 1);
    }
}
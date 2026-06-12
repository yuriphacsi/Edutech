<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        extract($data);

        $viewPath = dirname(__DIR__, 2) . "/views/{$view}.php";
        $layoutPath = dirname(__DIR__, 2) . "/views/{$layout}.php";

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if (!file_exists($layoutPath)) {
            die("Layout no encontrado: {$layout}");
        }

        require $layoutPath;
    }
}
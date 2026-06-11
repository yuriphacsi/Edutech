<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = dirname(__DIR__, 2)
            . '/views/'
            . $view
            . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("Vista no encontrada: {$view}");
        }
    }
}
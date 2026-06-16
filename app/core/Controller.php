<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = [], string $layout = null): void
    {
        extract($data);

        $viewPath = dirname(__DIR__, 2) . "/views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // 🔥 AUTO LAYOUT INTELIGENTE
        if ($layout === null) {
            $layout = $this->detectLayout($view);
        }

        $layoutPath = dirname(__DIR__, 2) . "/views/{$layout}.php";

        if (!file_exists($layoutPath)) {
            die("Layout no encontrado: {$layout}");
        }

        require $layoutPath;
    }

    private function detectLayout(string $view): string
    {
        // vistas públicas
        if ($view === 'home') {
            return 'layouts/public';
        }

        if (str_starts_with($view, 'auth')) {
            return 'layouts/auth';
        }

        // dashboard por defecto
        return 'layouts/main';
    }
}
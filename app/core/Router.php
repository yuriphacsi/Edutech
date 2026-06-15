<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $lastRoute;
    private string $lastMethod;

    public function get($route, $action)
    {
        $route = '/' . trim($route, '/');

        if ($route === '//') {
            $route = '/';
        }

        $this->routes['GET'][$route] = [
            'action' => $action,
            'middleware' => null
        ];

        $this->lastRoute = $route;
        $this->lastMethod = 'GET';

        return $this;
    }

    public function post(string $route, string $action): self
    {
        $route = '/' . trim($route, '/');

        if ($route === '//') {
            $route = '/';
        }

        $this->routes['POST'][$route] = [
            'action' => $action,
            'middleware' => null
        ];

        $this->lastRoute = $route;
        $this->lastMethod = 'POST';

        return $this;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace('/Edutech', '', $uri);

        $uri = '/' . trim($uri, '/');

        if ($uri === '//') {
            $uri = '/';
        }

        $actionData = $this->routes[$method][$uri] ?? null;

        if (!$actionData) {
            die("404 - Ruta no encontrada: $uri");
        }

        $middleware = $actionData['middleware'] ?? null;

        if ($middleware) {

            if ($middleware === 'auth') {
                \App\Middleware\AuthMiddleware::check();
            }

            if (str_starts_with($middleware, 'role:')) {

                $role = (int) str_replace('role:', '', $middleware);

                \App\Middleware\AuthMiddleware::role([$role]);
            }
        }

        $action = $actionData['action'];

        // 🔵 CASO 1: Controller@method (RECOMENDADO)
        if (is_string($action)) {

            [$controllerName, $methodAction] = explode('@', $action);

            $controllerClass = "App\\Controllers\\$controllerName";

            if (!class_exists($controllerClass)) {
                die("Controller no encontrado: $controllerClass");
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $methodAction)) {
                die("Método no existe: $methodAction en $controllerClass");
            }

            $controller->$methodAction();
            return;
        }

        // 🔵 CASO 2: [Controller::class, method]
        if (is_array($action)) {

            [$controller, $methodAction] = $action;

            if (!class_exists($controller)) {
                die("Controller no encontrado: $controller");
            }

            $controller = new $controller();

            if (!method_exists($controller, $methodAction)) {
                die("Método no existe: $methodAction");
            }

            $controller->$methodAction();
            return;
        }

        die("Acción inválida en ruta");
    }

    public function middleware($key)
    {
        $this->routes[$this->lastMethod][$this->lastRoute]['middleware'] = $key;
        return $this;
    }

    public function prueba()
    {
        die('Router cargado');
    }
}
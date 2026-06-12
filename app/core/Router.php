<?php

namespace App\Core;

class Router
{
    private array $middlewares = [];
    private string $lastRoute;
    private string $lastMethod;

    public function get($route, $action)
    {
        $this->routes['GET'][$route] = [
            'action' => $action,
            'middleware' => null
        ];

        return $this;
    }

    public function post(string $uri, string $action): self
    {
        $this->routes['POST'][$uri] = [
            'action' => $action,
            'middleware' => null
        ];

        $this->lastRoute = $uri;
        $this->lastMethod = 'POST';

        return $this;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');

        $uri = str_replace('/Edutech', '', $uri);

        $actionData = $this->routes[$method][$uri] ?? null;

        if (!$actionData) {
            die("404 - Ruta no encontrada: $uri");
        }

        $middleware = $actionData['middleware'] ?? null;

        if ($middleware) {

            if ($middleware === 'auth') {
                \App\Core\AuthMiddleware::check();
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
}
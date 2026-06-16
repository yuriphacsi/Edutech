<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    private string $lastRoute;
    private string $lastMethod;

    public function get($route, $action)
    {
        $route = $this->normalize($route);

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
        $route = $this->normalize($route);

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
        $uri = rtrim($uri, '/');

        if ($uri === '') {
            $uri = '/';
        }

        $actionData = $this->routes[$method][$uri] ?? null;

        if (!$actionData) {
            die("404 - Ruta no encontrada: $uri");
        }

        $middleware = $actionData['middleware'] ?? null;

        if ($middleware === 'auth') {
            \App\Core\AuthMiddleware::check();
        }

        if ($middleware && str_starts_with($middleware, 'role:')) {
            $role = (int) str_replace('role:', '', $middleware);
            \App\Middleware\AuthMiddleware::role([$role]);
        }

        $action = $actionData['action'];

        // Controller@method
        if (is_string($action)) {

            [$controllerName, $methodAction] = explode('@', $action);

            $controllerClass = "App\\Controllers\\$controllerName";

            $controller = new $controllerClass();
            $controller->$methodAction();
            return;
        }

        // [Controller::class, method]
        if (is_array($action)) {

            [$controller, $methodAction] = $action;

            $controller = new $controller();
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

    private function normalize(string $route): string
    {
        $route = '/' . trim($route, '/');

        return $route === '//' ? '/' : $route;
    }
}
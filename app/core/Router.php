<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, string $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function dispatch(string $uri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method][$uri])) {
            die('404 - Ruta no encontrada');
        }

        $action = $this->routes[$method][$uri];

        [$controller, $method] = explode('@', $action);

        $controllerClass = "App\\Controllers\\{$controller}";

        $controllerInstance = new $controllerClass();

        $controllerInstance->$method();
    }
}
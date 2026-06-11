<?php

require_once __DIR__ . '/vendor/autoload.php';

$router = require_once __DIR__ . '/config/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/Edutech';

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = $uri ?: '/';

$router->dispatch($uri);
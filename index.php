<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

$router = new Router();

require_once __DIR__ . '/config/routes.php';

$router->dispatch();
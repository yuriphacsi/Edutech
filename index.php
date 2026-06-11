<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Rol;

$rol = new Rol();

echo "<pre>";
print_r($rol->all());
echo "</pre>";
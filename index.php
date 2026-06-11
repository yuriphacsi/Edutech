<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Database;

try {

    $database = Database::getInstance();
    $connection = $database->getConnection();

    echo "✅ EduTech conectado correctamente a MySQL";

} catch (Exception $e) {

    echo "❌ Error: " . $e->getMessage();

}
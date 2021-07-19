<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv as DotenvDotenv;

if (file_exists(__DIR__ . '/../.env')) {
    (DotenvDotenv::createImmutable(__DIR__))->load();
}

define('DB_NAME', getenv('APP_DB_NAME'));
define('DB_USER', getenv('APP_DB_USER'));
define('DB_PASSWORD', getenv('APP_DB_PASSWORD'));
define('DB_HOST', getenv('APP_DB_HOST'));
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
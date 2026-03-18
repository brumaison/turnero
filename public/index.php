<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/helpers.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(basePath(''));
$dotenv->load();

use App\Core\Router;

$router = new Router();

// Cargar rutas desde config
$routes = require basePath('config/routes.php');
$routes($router);

$router->dispatch();
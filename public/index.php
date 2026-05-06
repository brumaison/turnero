<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/helpers.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(basePath(''));
$dotenv->load();


use Carbon\Carbon;
Carbon::setLocale($_ENV['APP_LOCALE'] ?? 'es');
Carbon::setTimezone('America/Argentina/Buenos_Aires');  // ← AGREGAR ESTO
// Timezone ya está seteado antes, pero si querés usar .env:
// date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'America/Argentina/Buenos_Aires');

use App\Core\Router;

$router = new Router();

// Cargar rutas desde config
$routes = require basePath('config/routes.php');
$routes($router);

$router->dispatch();
<?php
if (!function_exists('basePath')) {
    function basePath($path = '') {
        return __DIR__ . '/../../' . ltrim($path, '/');
    }
}

if (!function_exists('baseUrl')) {
    function baseUrl($path = '') {
        if (!empty($_ENV['APP_URL'])) {
            $base = rtrim($_ENV['APP_URL'], '/');
        } else {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);
            $base = $protocol . '://' . $host . ($script === '/' ? '' : $script);
        }
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('redirect')) {
    function redirect($path) {
        header('Location: ' . baseUrl($path));
        exit;
    }
}

if (!function_exists('old')) {
    function old($key, $default = '') {
        return $_POST[$key] ?? $default;
    }
}

// CSRF Functions
if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field() {
        echo '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            die('CSRF token validation failed');
        }
    }
}

if (!function_exists('config')) {
    function config($key, $default = null) {
        static $config = null;
        if ($config === null) {
            $config = require basePath('config/app.php');
        }
        return $config[$key] ?? $default;
    }
}
if (!function_exists('carbon_date')) {
    function carbon_date($fecha = null) {
        $c = \Carbon\Carbon::parse($fecha);
        $c->locale('es');  // ← Forzar locale en cada llamada
        return $c;
    }
}
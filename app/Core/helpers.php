<?php
if (!function_exists('basePath')) {
    function basePath($path = '') {
        return __DIR__ . '/../../' . ltrim($path, '/');
    }
}

if (!function_exists('baseUrl')) {
    function baseUrl($path = '') {
        $base = rtrim($_ENV['APP_URL'] ?? '', '/');
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
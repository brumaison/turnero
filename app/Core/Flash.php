<?php
namespace App\Core;

class Flash {
    public static function success($message) {
        $_SESSION['flash_success'] = $message;
    }

    public static function error($message) {
        $_SESSION['flash_error'] = $message;
    }

    public static function warning($message) {
        $_SESSION['flash_warning'] = $message;
    }

    public static function info($message) {
        $_SESSION['flash_info'] = $message;
    }

    public static function getSuccess() {
        $message = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_success']);
        return $message;
    }

    public static function getError() {
        $message = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_error']);
        return $message;
    }

    public static function getWarning() {
        $message = $_SESSION['flash_warning'] ?? null;
        unset($_SESSION['flash_warning']);
        return $message;
    }

    public static function getInfo() {
        $message = $_SESSION['flash_info'] ?? null;
        unset($_SESSION['flash_info']);
        return $message;
    }
}
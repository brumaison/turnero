<?php
namespace App\Core;

class Request {
    
    public function input($key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    public function all() {
        return array_merge($_POST, $_GET);
    }
    
    public function method() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function is($method) {
        return strtoupper($this->method()) === strtoupper($method);
    }
}
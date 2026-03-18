<?php
namespace App\Core;

class View {
    public static function render($path, $data = []) {
        extract($data);
        require basePath('app/Views/' . $path . '.php');
    }
}
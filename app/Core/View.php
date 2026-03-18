<?php
namespace App\Core;

class View {
    public static function render($path, $data = [], $useLayout = true) {
        extract($data);
        
        if (!$useLayout) {
            // Sin layout (para login, errores, etc.)
            require basePath('app/Views/' . $path . '.php');
            return;
        }
        
        // Con layout principal
        ob_start();
        require basePath('app/Views/' . $path . '.php');
        $content = ob_get_clean();

        require basePath('app/Views/layouts/main.php');
    }
}
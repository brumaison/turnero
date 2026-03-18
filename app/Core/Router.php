<?php
namespace App\Core;

class Router {
    protected $routes = [];
    
    protected $middlewareAliases = [
        'auth' => \App\Core\Middleware\AuthMiddleware::class,
    ];

    public function get($path, $handler, $middleware = []) {
        $this->routes['GET'][$path] = ['handler' => $handler, 'middleware' => $middleware];
    }

    public function post($path, $handler, $middleware = []) {
        $this->routes['POST'][$path] = ['handler' => $handler, 'middleware' => $middleware];
    }

    protected function getBasePath() {
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        return $scriptName === '/' ? '' : $scriptName;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $basePath = $this->getBasePath();
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $uri = rtrim($uri, '/');
        if ($uri === '') $uri = '/';

        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];

            // Ejecutar middleware
            foreach ($route['middleware'] as $mw) {
                $class = $this->middlewareAliases[$mw] ?? $mw;
                $instance = new $class();
                if (!$instance->handle()) {
                    return;
                }
            }

            // Ejecutar handler
            $handler = $route['handler'];
            
            if ($handler instanceof \Closure) {
                $handler();
            } elseif (is_array($handler)) {
                [$controllerClass, $method] = $handler;
                $controller = new $controllerClass();
                $controller->$method();
            }
        } else {
            http_response_code(404);
            echo "404 - Página no encontrada: " . $uri;
        }
    }
}
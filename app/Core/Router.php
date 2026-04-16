<?php
namespace App\Core;

class Router {
    protected $routes = [];
    
    protected $middlewareAliases = [
        'auth' => \App\Core\Middleware\AuthMiddleware::class,
        'role' => \App\Core\Middleware\RoleMiddleware::class,  
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

        // 1. Intentar match exacto primero (más rápido)
        if (isset($this->routes[$method][$uri])) {
            return $this->executeRoute($this->routes[$method][$uri], []);
        }

        // 2. Intentar match con parámetros dinámicos {id}, {slug}, etc.
        foreach ($this->routes[$method] as $routePath => $routeConfig) {
            if (strpos($routePath, '{') === false) continue;
            
            // Convertir {param} a regex capturable
            $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $routePath) . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                // Extraer solo los parámetros nombrados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return $this->executeRoute($routeConfig, $params);
            }
        }

        // 3. No encontrado
        http_response_code(404);
        echo "404 - Página no encontrada: " . $uri;
    }

    protected function executeRoute($routeConfig, $params) {
        // Ejecutar middleware
        foreach ($routeConfig['middleware'] as $mw) {
            // Parsear 'role:admin,recepcion' → ['role', ['admin','recepcion']]
            $parts = explode(':', $mw);
            $name = $parts[0];
            $mwParams = isset($parts[1]) ? explode(',', $parts[1]) : [];
            
            $class = $this->middlewareAliases[$name] ?? $name;
            $instance = new $class();
            
            if (!$instance->handle($mwParams)) {  // ← Pasar params
                return;
            }
        }

        // Ejecutar handler con parámetros
        $handler = $routeConfig['handler'];
        
        if ($handler instanceof \Closure) {
            $handler(...array_values($params));
        } elseif (is_array($handler)) {
            [$controllerClass, $method] = $handler;
            $controller = new $controllerClass();
            $controller->$method(...array_values($params));
        }
    }
}
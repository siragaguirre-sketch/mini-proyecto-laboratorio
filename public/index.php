<?php

/**
 * ============================================================================
 *  1. AUTOLOAD FLEXIBLE (Busca clases en src/ y sus subcarpetas)
 * ============================================================================
 */
spl_autoload_register(function ($class) {
    // Normalizar la clase (por si viene con namespace)
    $classFile = str_replace('\\', '/', $class) . '.php';

    // 1. Probar en la raíz de src/
    $baseDir = __DIR__ . '/../src/';
    if (file_exists($baseDir . $classFile)) {
        require_once $baseDir . $classFile;
        return;
    }

    // 2. Probar en subcarpetas de src/ (Controllers, Models, Services, etc.)
    $directories = ['Controllers', 'Models', 'Services', 'Database', 'Notifications', 'Pricing', 'Reports', 'Events', 'Legacy'];
    foreach ($directories as $dir) {
        $file = $baseDir . $dir . '/' . $classFile;
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

/**
 * ============================================================================
 *  2. CONFIGURACIÓN EXTERNA
 * ============================================================================
 */
$config = [
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'name' => 'laboratorio_db',
    ],
    'app' => [
        'env' => 'development',
        'debug' => true,
    ]
];

/**
 * ============================================================================
 *  3. TABLA DE RUTAS / ROUTER
 * ============================================================================
 */
class SimpleRouter
{
    private array $routes = [];

    public function addRoute(string $action, string $controllerClass, string $method): void
    {
        $this->routes[$action] = [
            'controller' => $controllerClass,
            'method'     => $method,
        ];
    }

    public function dispatch(string $action): void
    {
        if (!isset($this->routes[$action])) {
            http_response_code(404);
            echo "Página no encontrada (404)";
            return;
        }

        $route = $this->routes[$action];
        $controllerName = $route['controller'];
        $methodName = $route['method'];

        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
                return;
            }
        }

        http_response_code(500);
        echo "Error al procesar la ruta.";
    }
}

// Inicialización del Router y registro de las rutas según la tabla del README
$router = new SimpleRouter();
$router->addRoute('crear', 'OrderController', 'create');
$router->addRoute('listar', 'OrderController', 'index');
$router->addRoute('reporte', 'OrderController', 'report');

// Captura de la acción por GET (por defecto 'listar')
$accion = $_GET['accion'] ?? 'listar';

// Despacho de la ruta
$router->dispatch($accion);

<?php
declare(strict_types=1);

namespace App;

/**
 * Minimal router:
 *   /controller/action/param
 * Examples:
 *   /home/index
 *   /book/index
 *   /book/show/3
 *   /book/create   (GET)
 *   /book/store    (POST)
 *
 * Supports subfolder deployments via config['base_path'].
 */
final class Router
{
    public function __construct(private array $config) {}

    public function dispatch(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        // Remove base path prefix if the app lives in a subfolder
        $basePath = (string)($this->config['base_path'] ?? '');
        $basePath = rtrim($basePath, '/');
        if ($basePath !== '' && $basePath[0] !== '/') {
            $basePath = '/' . $basePath;
        }

        if ($basePath !== '' && substr($path, 0, strlen($basePath)) === $basePath) {
            $path = substr($path, strlen($basePath));
        }

        $path = trim($path, '/');
        $segments = $path === '' ? [] : explode('/', $path);

        $controllerName = $segments[0] ?? 'home';
        $actionName     = $segments[1] ?? 'index';
        $param          = $segments[2] ?? null;

        $class = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';

        if (!class_exists($class)) {
            http_response_code(404);
            echo "Controller not found: " . htmlspecialchars($class);
            return;
        }

        $controller = new $class($this->config);

        if (!method_exists($controller, $actionName)) {
            http_response_code(404);
            echo "Action not found: " . htmlspecialchars($actionName);
            return;
        }

        $param !== null ? $controller->{$actionName}($param) : $controller->{$actionName}();
    }
}

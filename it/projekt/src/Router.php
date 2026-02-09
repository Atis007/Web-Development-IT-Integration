<?php
declare(strict_types=1);

class Router {
    private array $routes = [];

    /**
     *
     *
     * @param string $method
     * @param string $path
     * @param string $file
     * @return void
     */
    public function add(string $method, string $path, string $file): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'file' => $file
        ];
    }

    /**
     * @param string $currentUri
     * @param string $currentMethod
     * @return void
     */
    public function dispatch(string $currentUri, string $currentMethod): void {
        // cut the BASE_URL from the URI
        $basePath = parse_url(BASE_URL, PHP_URL_PATH);
        $path = str_replace($basePath, '', $currentUri);

        // Removing query string
        $path = strtok($path, '?');

        if (!$path) $path = '/';

        if ($path[0] !== '/') {
            $path = '/' . $path;
        }

        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $currentMethod) {
                require_once PROJECT_ROOT . '/' . $route['file'];
                return;
            }
        }

        // If none found: 404
        http_response_code(404);
        echo "404 - Page not found: " . htmlspecialchars($path);
    }
}
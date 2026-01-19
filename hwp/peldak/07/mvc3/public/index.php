<?php
declare(strict_types=1);

// 1) Tiny autoloader (no Composer required)
spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . '/';
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

// 2) Load config
$config = require dirname(__DIR__) . '/config/config.php';

// 3) Base path support (for subfolder deployments)
define('BASE_PATH', rtrim((string)($config['base_path'] ?? ''), '/'));

// Simple URL helper used by views and controllers
function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    if (BASE_PATH === '') {
        return '/' . $path;
    }
    return BASE_PATH . '/' . $path;
}

// 4) Dispatch the request
$router = new App\Router($config);
$router->dispatch();

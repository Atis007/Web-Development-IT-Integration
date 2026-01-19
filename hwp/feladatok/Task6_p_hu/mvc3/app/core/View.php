<?php
declare(strict_types=1);

namespace App\core;

final class View
{
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $base = dirname(__DIR__) . '/views/';
        $viewFile = $base . $view . '.php';
        $layoutFile = $base . 'layout/' . $layout . '.php';

        if (!is_file($viewFile)) {
            throw new \RuntimeException("View not found: $viewFile");
        }
        if (!is_file($layoutFile)) {
            throw new \RuntimeException("Layout not found: $layoutFile");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require $layoutFile;
    }
}

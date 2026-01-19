<?php
declare(strict_types=1);

namespace App\core;

abstract class Controller
{
    public function __construct(protected array $config) {}

    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }
}

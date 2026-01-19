<?php
declare(strict_types=1);

namespace App\controllers;

use App\core\Controller;

final class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', [
            'title' => 'MVC3 – Home',
        ]);
    }
}

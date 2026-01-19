<?php
declare(strict_types=1);

namespace App\controllers;

use App\core\Controller;
use App\models\QuoteModel;

final class QuoteController extends Controller
{
    public function index(): void
    {
        $model = new QuoteModel($this->config);
        $quotes = $model->all();

        $this->render('quote/index', [
            'title' => 'Quotes',
            'quotes' => $quotes,
        ]);
    }

    public function show(string $id): void
    {
        $idInt = (int)$id;
        if ($idInt <= 0) {
            http_response_code(400);
            echo "Bad request";
            return;
        }

        $model = new QuoteModel($this->config);
        $quote = $model->find($idInt);

        if ($quote === null) {
            http_response_code(404);
            echo "Quote not found";
            return;
        }

        $this->render('quote/show', [
            'title' => 'Quote Details',
            'quote' => $quote,
        ]);
    }
}

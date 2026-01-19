<?php
declare(strict_types=1);

namespace App\controllers;

use App\core\Controller;
use App\models\BookModel;

final class BookController extends Controller
{
    public function index(): void
    {
        $model = new BookModel($this->config);
        $books = $model->all();

        $this->render('book/index', [
            'title' => 'Books',
            'books' => $books,
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

        $model = new BookModel($this->config);
        $book = $model->find($idInt);

        if ($book === null) {
            http_response_code(404);
            echo "Book not found";
            return;
        }

        $this->render('book/show', [
            'title' => 'Book details',
            'book'  => $book,
        ]);
    }

    // GET /book/create -> shows form
    public function create(): void
    {
        $this->render('book/create', [
            'title' => 'Add a new book',
            'error' => null,
        ]);
    }

    // POST /book/store -> inserts record via PDO
    public function store(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            echo "Method Not Allowed";
            return;
        }

        $title  = trim((string)($_POST['title'] ?? ''));
        $author = trim((string)($_POST['author'] ?? ''));

        if ($title === '' || $author === '') {
            $this->render('book/create', [
                'title' => 'Add a new book',
                'error' => 'Both title and author are required.',
            ]);
            return;
        }

        $model = new BookModel($this->config);
        $newId = $model->create($title, $author);

        header('Location: ' . url('book/show/' . $newId));
        exit;
    }
}

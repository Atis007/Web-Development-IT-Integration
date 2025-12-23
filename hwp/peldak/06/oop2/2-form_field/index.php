<?php
require_once __DIR__ . '/vendor/autoload.php';

use MyApp\Form;
use MyApp\Field;
use MyApp\User;

$userModel = new User();


$userId = $userModel->createUser('John Doe', 'john@example.com');
echo "New user inserted with ID: $userId\n";

$user = $userModel->getUserById($userId);
echo "User fetched: " . var_dump($user, true) . "\n";


$form = new Form("exampleForm", "post", "submit.php", "form-id", "form-class");

$nameField = new Field("name", "text", "", 'name-id', 30, "Name");
$emailField = new Field("email", "email", "", "email-id", 30, "Email");
$submitButton = new Field("submit", "submit", "Submit");

echo $form->renderStart();
echo $nameField->render();
echo $emailField->render();
echo $submitButton->render();
echo $form->renderEnd();

// composer dump-autoload
// https://www.php-fig.org/psr/

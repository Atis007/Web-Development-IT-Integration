<?php
include 'config.php';
include 'functions.php';
$title = "Task10 - Process";
include "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $reservedDate = $_POST['date'];

    [$modifiedName, $modifiedEmail, $modifiedDate] = processText($name, $email, $reservedDate); //destructuring the returned values

    $pdo = connectDatabase($dsn, $pdoOptions);

    insertData($pdo, $modifiedName, $modifiedEmail, $modifiedDate);
    echo "Successfully added to db!";

} else {
    exit("Invalid request");
}

include "includes/footer.php";
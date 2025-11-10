<?php
include 'includes/functions.php';
include 'config.php';
$pdo = connectDatabase($dsn, $pdoOptions);
$title="Search";
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = trim($_POST['search'] ?? '');

    $words = explode(' ', $search);

    $results = searchEveryWord($pdo, $words);

    $searchContent = implode(' ', $words);
    $resultsString = implode(',', $results);

    insertToSearch($pdo, $searchContent, $resultsString);
}

include 'includes/footer.php';
<?php
require 'includes/functions.php';

$pdo = $GLOBALS['pdo'];

$users = createUsers(NAMES, LEVELS);
var_dump($users);

for($i=0; $i<count($users); $i++) {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, age, email, level, date_time_added) VALUES (:name, :pw,:age,:email,:lvl, NOW())");
    $stmt->execute([
        ':name' => $users[$i]['username'],
        ':pw' => $users[$i]['hashed_password'],
        ':age' => $users[$i]['age'],
        ':email' => $users[$i]['email'],
        ':lvl' => $users[$i]['level'],
    ]);
}
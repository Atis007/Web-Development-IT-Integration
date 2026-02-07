<?php
declare(strict_types=1);

$_SESSION = [];

session_destroy();

header('Location: ' . BASE_URL);
exit;

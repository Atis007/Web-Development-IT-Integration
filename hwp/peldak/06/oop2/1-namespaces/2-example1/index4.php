<?php

require 'autoload.php';

use Service\EmailService;

$emailService = new EmailService();

echo $emailService->send(
    "user@example.com",
    "Welcome to our application!"
);

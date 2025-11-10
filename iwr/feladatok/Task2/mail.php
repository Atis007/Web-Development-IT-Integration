<?php
include 'blocked_country.php';
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = getenv('HOST');
$port = getenv('PORT');
$username = getenv('USERNAME');
$password = getenv('PASSWORD');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if(empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        exit("All fields must be filled");
    }

    if(strlen($message) < 10 || strlen($message) > 100) {
        exit("Message must be between 10 and 100 characters");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Type in a valid email.\n");
    }

    try {
        // Looking to send emails in production? Check out our Email API/SMTP product!
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $host;
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $port;
        $phpmailer->Username = $username;
        $phpmailer->Password = $password;

        //Recipients
        $phpmailer->CharSet = 'UTF-8';
        $phpmailer->setFrom('noreply@example.com', 'Website Form');

        $phpmailer->addReplyTo($email, "$firstName $lastName");

        $phpmailer->addAddress('support@example.com', 'Support team');

        //Content
        $phpmailer->isHTML(true); //Set email format to HTML
        $phpmailer->Subject = "Form submission data";
        $phpmailer->Body    = "Name: $firstName $lastName<br>" .
            "Email: $email<br>" .
            "Message:<br>" . nl2br($message);

        $phpmailer->AltBody = "Name: $firstName $lastName\n" .
            "Email: $email\n" .
            "Message:\n$message";

        $phpmailer->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: $phpmailer->ErrorInfo";
    }
} else {
    exit("Invalid request");
}
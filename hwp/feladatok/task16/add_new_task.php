<?php
$pdo = $GLOBALS['pdo'];
include 'includes/functions.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('new_task', "Only POST requests are allowed!");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$id = $_POST["selected_project_id"];
$task = trim($_POST["task"]);
$desc = trim($_POST["description"]);

if ($id === "" || $task === "" || $desc === "") {
    redirectFn('edit_users', "Must provide a selected user, a task title and a task description!");
}

updateProject($pdo, $id, $task, $desc);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['MT_HOST'];                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Port       = $_ENV['MT_PORT'];                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->Username   = $_ENV['MT_USERNAME'];                       //SMTP username
    $mail->Password   = $_ENV['MT_PASSWORD'];                       //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    //Recipients
    $mail->setFrom('no-reply@updated.com', 'Admin');
    $mail->addAddress('admin@company.com');

    $bodyMsg = "New task title:" . $task . "<br>" .
        "New task description: " . $desc . "<br>";

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Your data has been updated!";
    $mail->Body    = $bodyMsg;
    $mail->AltBody = $bodyMsg;

    $mail->send();

    redirectFn('edit_users', "Sikeres adatmódosítás és e-mail küldés!");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
}
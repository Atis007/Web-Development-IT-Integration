<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

session_start();
include 'includes/functions.php';
$pdo = $GLOBALS['pdo'];
$currentUser = assertAuthenticated($pdo, ['user']);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('new_task', "Only POST requests are allowed!");
}

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$projectId = isset($_POST["selected_project_id"]) ? (int)$_POST["selected_project_id"] : 0;
$task = trim($_POST["task"] ?? '');
$desc = trim($_POST["description"] ?? '');

if ($projectId <= 0 || $task === "" || $desc === "") {
    redirectFn('new_task', "Must provide a project, task title and description!");
}

$project = getProjectById($pdo, $projectId);
if (!$project) {
    redirectFn('new_task', "Invalid project selected!");
}

addTask($pdo, (int)$currentUser['id_user'], $projectId, $task, $desc);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $_ENV['MT_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Port       = $_ENV['MT_PORT'];
    $mail->Username   = $_ENV['MT_USERNAME'];
    $mail->Password   = $_ENV['MT_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->setFrom('no-reply@company.com', 'Task Board');
    $mail->addAddress('admin@company.com');

    $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');
    $bodyMsg = "Project: " . htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8') . "<br>" .
        "Task: " . htmlspecialchars($task, ENT_QUOTES, 'UTF-8') . "<br>" .
        "Description: " . nl2br(htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')) . "<br>" .
        "Added by: " . htmlspecialchars($currentUser['name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') . "<br>" .
        "Date: " . $now;

    $mail->isHTML(true);
    $mail->Subject = "New task created";
    $mail->Body    = $bodyMsg;
    $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $bodyMsg));

    $mail->send();

    redirectFn('new_task', "Task saved and notification sent.");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
}
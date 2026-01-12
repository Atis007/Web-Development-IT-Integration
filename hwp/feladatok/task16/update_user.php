<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

session_start();
require 'includes/functions.php';
$pdo = $GLOBALS["pdo"];

$currentUser = assertAuthenticated($pdo, ['admin', 'supervisor']);

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('edit_users', "Only POST requests are allowed!");
}

$id = isset($_POST["id_user"]) ? (int)$_POST["id_user"] : 0;
$salary = trim($_POST["salary"] ?? '');
$city = trim($_POST["city"] ?? '');
$pw = $_POST["passwordReset"] ?? '';
$bio = trim($_POST["biography"] ?? '');
$status = $_POST['status'] ?? '';

if ($id === 0 || $salary === "" || $pw === "" || $bio === "" || $status === '') {
    redirectFn('edit_users', "Must provide user, salary, password, biography and status!");
}

$targetUser = getUserById($pdo, $id);
if (!$targetUser || $targetUser['role'] !== 'user') {
    redirectFn('edit_users', "Selected user is invalid.");
}

if(!is_numeric($salary)){
    redirectFn('edit_users', "Salary must be an integer!");
}

if(strlen($pw) < 8){
    redirectFn('edit_users', "Password must be at least 8 characters!");
}

if(!in_array($status, ['active','inactive'], true)) {
    redirectFn('edit_users', "Status must be active or inactive!");
}

$filteredBio = filterText($bio);

$updated = updateUser($pdo, $id, $city, (int)$salary, $pw, $filteredBio, $status);

$mail = new PHPMailer(true);
$adminMail = null;

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

    $mail->setFrom('no-reply@company.com', 'Admin');
    $mail->addAddress($targetUser['email']);

    $bodyMsg = "Your new salary: " . $updated['salary'] . "<br>" .
        "Your new biography: " . $updated['biography'] . "<br>" .
        "Your new password: " . $updated['password_updated'] . "<br>" .
        "Status: " . $updated['status'] . "<br>";

    if (!empty($updated['city'])) {
        $bodyMsg .= "Your city: " . $updated['city'] . "<br>";
    }

    $bodyMsg .= "Save this email so you know your password!";

    $mail->isHTML(true);
    $mail->Subject = "Your data has been updated!";
    $mail->Body    = $bodyMsg;
    $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $bodyMsg));

    if($currentUser['role'] === 'supervisor'){
        $adminMail = new PHPMailer(true);
        $adminMail->isSMTP();
        $adminMail->Host       = $_ENV['MT_HOST'];
        $adminMail->SMTPAuth   = true;
        $adminMail->Port       = $_ENV['MT_PORT'];
        $adminMail->Username   = $_ENV['MT_USERNAME'];
        $adminMail->Password   = $_ENV['MT_PASSWORD'];
        $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $adminMail->CharSet = 'UTF-8';
        $adminMail->Encoding = 'base64';

        $adminMail->setFrom('no-reply@company.com', 'Supervisor');
        $adminMail->addAddress('admin@company.com');

        $bodyMsgAdmin = "User ID: " . $updated['id_user'] . " data has been updated.<br>" .
            "Salary: " . $updated['salary'] . "<br>" .
            "Biography: " . $updated['biography'] . "<br>" .
            "Status: " . $updated['status'] . "<br>";

        if (!empty($updated['city'])) {
            $bodyMsgAdmin .= "City: " . $updated['city'] . "<br>";
        }

        $adminMail->isHTML(true);
        $adminMail->Subject = "User data updated";
        $adminMail->Body    = $bodyMsgAdmin;
        $adminMail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $bodyMsgAdmin));
    }

    $mail->send();
    if ($adminMail) {
        $adminMail->send();
    }

    redirectFn('edit_users', "Sikeres adatmódosítás és e-mail küldés!");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
    if ($adminMail) {
        echo " Admin message could not be sent. Mailer Error: $adminMail->ErrorInfo";
    }
}
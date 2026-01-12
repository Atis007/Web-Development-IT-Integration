<?php
session_start();
require 'includes/functions.php';
$pdo = $GLOBALS["pdo"];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redirectFn('edit_users', "Only POST requests are allowed!");
}

$id = $_POST["id_user"];
$salary = trim($_POST["salary"]);
$city = trim($_POST["city"]);
$pw = $_POST["passwordReset"];
$bio = trim($_POST["biography"]);
$userEmail = $_POST["email"];

if ($id === "" || $salary === "" || $pw === "" || $bio === "") {
    redirectFn('edit_users', "Must provide a selected user, a new salary, password, and biography!");
}

if(!is_numeric($salary)){
    redirectFn('edit_users', "Salary must be an integer!");
}

if(strlen($pw) < 8){
    redirectFn('edit_users', "Password must be at least 8 characters!");
}

$filteredBio = filterText($bio);

$updated = updateUser($pdo, $id, $city, $salary, $pw, $filteredBio);

if ($_SESSION['role'] === 'supervisor'){
    $mail = new PHPMailer(true);
    $adminMail = new PHPMailer(true);

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

        $adminMail->isSMTP();                                            //Send using SMTP
        $adminMail->Host       = $_ENV['MT_HOST'];                       //Set the SMTP server to send through
        $adminMail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $adminMail->Port       = $_ENV['MT_PORT'];                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $adminMail->Username   = $_ENV['MT_USERNAME'];                       //SMTP username
        $adminMail->Password   = $_ENV['MT_PASSWORD'];                       //SMTP password
        $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $adminMail->CharSet = 'UTF-8';
        $adminMail->Encoding = 'base64';

        //Recipients
        $mail->setFrom('no-reply@updated.com', 'Admin');
        $mail->addAddress($userEmail);

        $adminMail->setFrom('no-reply@updated.com', 'Admin');
        $adminMail->addAddress('admin@vts.rs');

        $bodyMsg = "Your new salary:" . $updated['salary'] . "<br>" .
                   "Your new biography: " . $updated['biography'] . "<br>" .
                   "Your new password: " . $updated['password_updated'] . "<br>";

        if ($updated['city']  !== '') {
            $bodyMsg .= "Your city: " . $updated['city'] . "<br>";
        }

        $bodyMsg .= "Save this email so you know your password!";

        $bodyMsgAdmin = "User:" . $updated['id_user'] . " credentials have been updated.<br>" .
                        "The users new salary:" . $updated['salary'] . "<br>" .
                        "new biography: " . $updated['biography'] . "<br>";

        if ($updated['city']  !== '') {
            $bodyMsgAdmin .= "and new city: " . $updated['city'] . "<br>";
        }

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Your data has been updated!";
        $mail->Body    = $bodyMsg;
        $mail->AltBody = $bodyMsg;

        $mail->send();

        $adminMail->isHTML(true);                                  //Set email format to HTML
        $adminMail->Subject = "Your data has been updated!";
        $adminMail->Body    = $bodyMsgAdmin;
        $adminMail->AltBody = $bodyMsgAdmin;

        $adminMail->send();

        redirectFn('edit_users', "Sikeres adatmódosítás és e-mail küldés!");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
        echo "Admin message could not be sent. Mailer Error: $adminMail->ErrorInfo";
    }
}

if($_SESSION['role'] === 'admin'){
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
        $mail->addAddress($userEmail);

        $bodyMsg = "Your new salary:" . $updated['salary'] . "<br>" .
            "Your new biography: " . $updated['biography'] . "<br>" .
            "Your new password: " . $updated['password_updated'] . "<br>";

        if ($updated['city']  !== '') {
            $bodyMsg .= "Your city: " . $updated['city'] . "<br>";
        }

        $bodyMsg .= "Save this email so you know your password!";

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
}
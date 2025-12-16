<?php
require "includes/functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = $GLOBALS['pdo'];

$data = dynamicHolidays($pdo);

if (empty($data)) {
    $hasHoliday = false;
    $name = "There is no holiday in the database that matches today's event.";
} else {
    $hasHoliday = true;
    $name = $data['name'];
    $picture = $data['picture'];
    $slogan = $data['slogan'];
    $current_datetime = date('Y.m.d ');

    $sloganMd5 = md5($slogan);

    setcookie('HOLIDAY_SLOGAN', $sloganMd5, time() + 900);
}

$today = date("Y-m-d");
$mailAlreadySent = isset($_COOKIE['HOLIDAY_MAIL_SENT']) && $_COOKIE['HOLIDAY_MAIL_SENT'] == $today;

if($hasHoliday === true && !$mailAlreadySent) {
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
        $mail->setFrom('no-reply@holiday.com', 'Holiday Notification');
        $mail->addAddress('admin@vts.rs');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Today is $name!";
        $mail->Body    = "Happy <strong>$name</strong>! Today's day is all about: <em>$slogan</em>.";
        $mail->AltBody = "Happy $name! Today's day is all about: $slogan.";

        $mail->send();

        setcookie(
                'HOLIDAY_MAIL_SENT',
                $today,
                time() + 86400, //24 h
                '/'
        );

        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$title = "Today's holiday";
include_once 'includes/header.php';
?>
<div style="display: flex; justify-content: center; align-items: center">
    <div style="text-align: center">
        <?php if (!$hasHoliday): ?>
            <p><?= htmlspecialchars($name) ?></p>
        <?php else: ?>
            <h1><?= htmlspecialchars($name) ?></h1>
            <h3><?= htmlspecialchars($slogan) ?></h3>
            <img src="pictures/<?= htmlspecialchars($picture) ?>" alt="picture about the current holiday">
            <p><?= $current_datetime ?><span id="clock"></span></p>
        <?php endif; ?>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>

<?php
require 'includes/config.php';

$fName = $_GET['firstname'] ?? '';
$lName = $_GET['lastname'] ?? '';
$pickup = $_GET['pickup'] ?? '';
$treatment = $_GET['treatments'] ?? '';
$date = $_GET['arrival'] ?? '';

if ($fName === '' || $lName === '' || $pickup === '' || $treatment === '' || $date === '') {
    header('Location:home.php?error=Everything must be filled out.');
    exit;
}

if (!in_array($treatment, $GLOBALS['treatments'], true)) {
    header('Location:public/home.php?error=Not a valid treatment.');
    exit;
}

$price = 0;
require 'includes/count.php';
$title = "Reservation";
require 'includes/header.php';

$now = date('Y-m-d');
$dateArray = explode('-', $now);
$day = (int)$dateArray[2];
if ($day % 2 === 0) {
    $color = '#00f';
    $size = 20;
} else {
    $color = '#0f0';
    $size = 18;
}
?>
<div class="main-content">
    <div style="width: 100%; background-color: white; padding: 40px; text-align: center;">
        <h1 style="color: #7A9E1E;">Pricing details</h1>

        <p>Welcome <span style="color: <?php echo $color ?>; font-size: <?php echo $size ?>px;"><?php echo $fName . " " . $lName; ?></span>!</p>
        <p>You chose: <span style="color: <?php echo $color ?>; font-size: <?php echo $size ?>px;"><?php echo ucfirst(str_replace('_', ' ', $treatment)); ?></span></p>
        <p>Arriving at: <span style="color: <?php echo $color ?>; font-size: <?php echo $size ?>px;"><?php echo $date; ?></span></p>

        <div style="background-color: #f9f9f9; padding: 20px; margin: 20px auto; border-radius: 5px; display: inline-block;">
            <p>Price: <?php echo number_format($price, 0, ',', ' '); ?> Rsd</p>
            <p>TAX (<?php echo PDV * 100; ?>%): <?php echo number_format($price * PDV, 0, ',', ' '); ?> Rsd</p>
            <h2 style="color: #333;">Final Price: <span style="color: <?php echo $color ?>; font-size: <?php echo $size ?>px;"><?php echo number_format($finalPrice, 0, ',', ' '); ?> Rsd</span></h2>
        </div>

        <br>
        <a href="index.php" style="color: #7A9E1E; font-weight: bold; text-decoration: none;">&larr; New Reservation</a>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
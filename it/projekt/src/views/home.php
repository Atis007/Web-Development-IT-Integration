<?php
$title = "Home";
$metaDescription = "A php projekt kezdőoldala";
$metaRobots = "index, follow";
require PROJECT_ROOT . '/templates/header.php';

$randomMessage = returnRandomMessage();
$greeting = $randomMessage['greeting'];
$message = $randomMessage['message'];

if (isset($_GET['success'])) {
    $punctuationMark = mb_substr($greeting, -1);
    $name = htmlspecialchars($_GET['success']);
    $greeting = mb_substr($greeting, 0, -1);
    $greeting .= " " . $name . $punctuationMark;
} else if (isset($_SESSION["fullname"])) {
    $punctuationMark = mb_substr($greeting, -1);
    $name = htmlspecialchars($_SESSION["fullname"]);
    $greeting = mb_substr($greeting, 0, -1);
    $greeting .= " " . $name . $punctuationMark;
}
?>

<main class="container">
    <section class="card">
        <h1><?php echo $greeting; ?></h1>
        <p><?php echo $message; ?></p>
    </section>
    
    <section class="card">
        <h2>Menu</h2>
        <ul>
            <li>Signature burgers and house-made sauces</li>
            <li>Fresh salads and seasonal bowls</li>
            <li>Classic pizzas with quality toppings</li>
        </ul>
        <a class="btn" href="<?php echo BASE_URL; ?>menu">See Menu</a>
    </section>

    <section class="card">
        <h2>Why You Should Order from Us</h2>
        <ul>
            <li>Quick preparation and clear pickup times</li>
            <li>Clean ingredients and balanced portions</li>
            <li>Friendly support for any order questions</li>
        </ul>
    </section>
</main>

<?php include PROJECT_ROOT . '/templates/footer.php'; ?>
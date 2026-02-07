<?php
$title = 'About Us';
$metaDescription = 'Learn about our food ordering service, our story, and what we serve.';
require PROJECT_ROOT . '/templates/header.php';
?>

<main class="container">
	<section class="card">
		<h1>About Us</h1>
		<p>We are a small, local team passionate about fresh ingredients and fast, friendly service. Our food ordering page is built to make your meal simple: browse, choose, and enjoy.</p>
		<p>Every order is prepared with care, using seasonal produce and trusted suppliers from the neighborhood. Whether you want a quick lunch or a family dinner, we’ve got you covered.</p>
	</section>

	<section class="card">
		<h2>What We Offer</h2>
		<ul>
			<li>Daily specials made from fresh, local ingredients</li>
			<li>Vegetarian and gluten-friendly options</li>
			<li>Fast pickup and reliable delivery</li>
		</ul>
	</section>

	<section class="card">
		<h2>Our Promise</h2>
		<p>Great food, honest prices, and a smooth ordering experience. If something isn’t right, we’ll make it right.</p>
		<a class="btn" href="<?php echo BASE_URL; ?>contact">Contact</a>
	</section>
</main>

<?php include PROJECT_ROOT . '/templates/footer.php'; ?>

<?php
$title = 'Contact Us';
$metaDescription = 'Get in touch with our food ordering team for support or questions.';
require PROJECT_ROOT . '/templates/header.php';
?>

<main class="container">
	<section class="card">
		<h1>Contact Us</h1>
		<p>Have a question about your order? Reach out and we’ll reply as soon as possible.</p>
		<p>
			<strong>Phone:</strong> +36 30 123 4567<br>
			<strong>Email:</strong> hello@freshbite.example<br>
			<strong>Hours:</strong> Mon–Sat, 10:00–21:00
		</p>
	</section>

	<section class="card">
		<h2>Send Us a Message</h2>
		<form action="#" method="post">
			<p>
				<label for="name">Name</label><br>
				<input type="text" id="name" name="name" required>
			</p>
			<p>
				<label for="email">Email</label><br>
				<input type="email" id="email" name="email" required>
			</p>
			<p>
				<label for="message">Message</label><br>
				<textarea id="message" name="message" rows="5" required></textarea>
			</p>
			<button type="submit">Send Message</button>
		</form>
	</section>
</main>

<?php include PROJECT_ROOT . '/templates/footer.php'; ?>

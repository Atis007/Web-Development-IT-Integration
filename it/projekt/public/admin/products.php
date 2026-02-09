<?php

declare(strict_types=1);

require __DIR__ . '/../../config/config.php';
require PROJECT_ROOT . '/src/functions.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (empty($_SESSION['logged_in']) || ($_SESSION['role'] ?? '') !== 'admin') {
	header('Location: ' . BASE_URL);
	exit;
}

$title = 'Products Admin';
$metaDescription = 'Manage products.';
require PROJECT_ROOT . '/templates/header.php';

$categories = getCategories($pdo);
$products = getAllProductsWithCategory($pdo);
$actionUrl = BASE_URL . 'admin/check-product';
?>

<main class="container admin-page">
	<?php if (isset($_GET['error'])): ?>
		<p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
	<?php endif; ?>
	<?php if (isset($_GET['success'])): ?>
		<p class="success-message"><?php echo htmlspecialchars($_GET['success']); ?></p>
	<?php endif; ?>
	<h1>Products</h1>
	<div class="admin-grid">
		<section class="card">
			<h2>Create</h2>
			<form method="post" action="<?php echo htmlspecialchars($actionUrl); ?>">
				<input type="hidden" name="action" value="<?php echo ACTIONS[0]; ?>">
				<p>
					<label for="create-name">Name</label><br>
					<input type="text" id="create-name" name="name" required>
				</p>
				<p>
					<label for="create-category">Category</label><br>
					<select id="create-category" name="category_id" required>
						<option value="">Select category</option>
						<?php foreach ($categories as $category): ?>
							<option value="<?php echo (int)$category['id']; ?>">
								<?php echo htmlspecialchars($category['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label for="create-description">Description</label><br>
					<textarea id="create-description" name="description" rows="3"></textarea>
				</p>
				<p>
					<label for="create-price">Price</label><br>
					<input type="number" id="create-price" name="price" min="0" required>
				</p>
				<button type="submit" class="btn">Add product</button>
			</form>
		</section>

		<section class="card">
			<h2>Read</h2>
			<div class="admin-table-wrap">
				<table class="admin-table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Category</th>
							<th class="admin-table-right">Price (RSD)</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($products as $product): ?>
							<tr>
								<td><?php echo htmlspecialchars($product['name']); ?></td>
								<td><?php echo htmlspecialchars($product['category_name']); ?></td>
								<td class="admin-table-right">
									<?php echo number_format((float)$product['price'], 0); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>

		<section class="card">
			<h2>Update</h2>
			<form method="post" action="<?php echo htmlspecialchars($actionUrl); ?>">
				<input type="hidden" name="action" value="<?php echo ACTIONS[1]; ?>">
				<p>
					<label for="update-product">Product</label><br>
					<select id="update-product" name="product_id" required>
						<option value="">Select product</option>
						<?php foreach ($products as $product): ?>
							<option
								value="<?php echo (int)$product['id']; ?>"
								data-name="<?php echo htmlspecialchars($product['name']); ?>"
								data-category="<?php echo (int)$product['category_id']; ?>"
								data-description="<?php echo htmlspecialchars($product['description'] ?? ''); ?>"
								data-price="<?php echo htmlspecialchars((string)$product['price']); ?>">
								<?php echo htmlspecialchars($product['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label for="update-name">Name</label><br>
					<input type="text" id="update-name" name="name" required>
				</p>
				<p>
					<label for="update-category">Category</label><br>
					<select id="update-category" name="category_id" required>
						<option value="">Select category</option>
						<?php foreach ($categories as $category): ?>
							<option value="<?php echo (int)$category['id']; ?>">
								<?php echo htmlspecialchars($category['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label for="update-description">Description</label><br>
					<textarea id="update-description" name="description" rows="3"></textarea>
				</p>
				<p>
					<label for="update-price">Price</label><br>
					<input type="number" id="update-price" name="price" min="0" required>
				</p>
				<button type="submit" class="btn">Update product</button>
			</form>
		</section>

		<section class="card">
			<h2>Delete</h2>
			<form method="post" action="<?php echo htmlspecialchars($actionUrl); ?>" onsubmit="return confirm('Delete this product?');">
				<input type="hidden" name="action" value="<?php echo ACTIONS[2]; ?>">
				<p>
					<label for="delete-product">Product</label><br>
					<select id="delete-product" name="product_id" required>
						<option value="">Select product</option>
						<?php foreach ($products as $product): ?>
							<option value="<?php echo (int)$product['id']; ?>">
								<?php echo htmlspecialchars($product['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</p>
				<button type="submit" class="btn">Delete product</button>
			</form>
		</section>
	</div>
</main>

<?php include PROJECT_ROOT . '/templates/footer.php'; ?>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const productSelect = document.getElementById('update-product');
		const nameInput = document.getElementById('update-name');
		const categorySelect = document.getElementById('update-category');
		const descriptionInput = document.getElementById('update-description');
		const priceInput = document.getElementById('update-price');

		if (!productSelect) return;

		productSelect.addEventListener('change', () => {
			const opt = productSelect.selectedOptions[0];
			if (!opt || !opt.value) {
				nameInput.value = '';
				categorySelect.value = '';
				descriptionInput.value = '';
				priceInput.value = '';
				return;
			}

			nameInput.value = opt.dataset.name || '';
			categorySelect.value = opt.dataset.category || '';
			descriptionInput.value = opt.dataset.description || '';
			priceInput.value = opt.dataset.price || '';
		});
	});
</script>
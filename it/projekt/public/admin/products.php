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

require './actions/product_actions.php';

$statusMessage = '';
$statusType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = $_POST['action'] ?? '';

	if ($action === 'create') {
		$name = trim($_POST['name'] ?? '');
		$description = trim($_POST['description'] ?? '');
		$price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT);
		$categoryId = filter_var($_POST['category_id'] ?? null, FILTER_VALIDATE_INT);

		if ($name === '' || $price === false || $categoryId === false) {
			$statusMessage = 'Name, category, and price are required.';
			$statusType = 'error';
		} else {
			$sql = "INSERT INTO products (category_id, name, description, price) VALUES (:category_id, :name, :description, :price)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':category_id' => $categoryId,
				':name' => $name,
				':description' => $description !== '' ? $description : null,
				':price' => $price,
			]);
			$statusMessage = 'Product created.';
			$statusType = 'success';
		}
	}

	if ($action === 'update') {
		$productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);
		$name = trim($_POST['name'] ?? '');
		$description = trim($_POST['description'] ?? '');
		$price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_INT);
		$categoryId = filter_var($_POST['category_id'] ?? null, FILTER_VALIDATE_INT);

		if ($productId === false || $name === '' || $price === false || $categoryId === false) {
			$statusMessage = 'Product, name, category, and price are required.';
			$statusType = 'error';
		} else {
			$sql = "UPDATE products SET category_id = :category_id, name = :name, description = :description, price = :price WHERE id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':category_id' => $categoryId,
				':name' => $name,
				':description' => $description !== '' ? $description : null,
				':price' => $price,
				':id' => $productId,
			]);
			$statusMessage = 'Product updated.';
			$statusType = 'success';
		}
	}

	if ($action === 'delete') {
		$productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);

		if ($productId === false) {
			$statusMessage = 'Product is required.';
			$statusType = 'error';
		} else {
			$sql = "DELETE FROM products WHERE id = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id' => $productId]);
			$statusMessage = 'Product deleted.';
			$statusType = 'success';
		}
	}
}

$categoriesStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $categoriesStmt->fetchAll();

$productsStmt = $pdo->query(
	"SELECT p.id, p.name, p.description, p.price, c.name AS category_name, p.category_id
	 FROM products p
	 JOIN categories c ON c.id = p.category_id
	 ORDER BY p.name"
);
$products = $productsStmt->fetchAll();
?>

<main class="container admin-page">
	<h1>Products</h1>

	<?php if ($statusMessage !== ''): ?>
		<p class="<?php echo $statusType === 'error' ? 'error-message' : 'success-message'; ?>">
			<?php echo htmlspecialchars($statusMessage); ?>
		</p>
	<?php endif; ?>

	<div class="admin-grid">
		<section class="card">
			<h2>Create</h2>
			<form method="post">
				<input type="hidden" name="action" value="create">
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
			<form method="post">
				<input type="hidden" name="action" value="update">
				<p>
					<label for="update-product">Product</label><br>
					<select id="update-product" name="product_id" required>
						<option value="">Select product</option>
						<?php foreach ($products as $product): ?>
							<option value="<?php echo (int)$product['id']; ?>">
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
			<form method="post" onsubmit="return confirm('Delete this product?');">
				<input type="hidden" name="action" value="delete">
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

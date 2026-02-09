<?php
$title = 'Menu';
$metaDescription = 'Choose from many of our delicious menu options.';
require PROJECT_ROOT . '/templates/header.php';

$categories = getCategories($GLOBALS['pdo']);
?>

<form class="container" action="<?php echo BASE_URL; ?>order-action" method="post">
    <section class="card accordion-wrap">
        <?php if (empty($_SESSION["logged_in"])): ?>
            <p>If you want to order online, you need to be logged in first, or call us.</p>
        <?php endif; ?>
        <?php if (isset($_GET['orderError'])): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($_GET['orderError']); ?></p>
            </div>
        <?php endif; ?>
        <?php if (empty($categories)): ?>
            <p>No categories available.</p>
        <?php else: ?>
            <?php foreach ($categories as $category) : ?>
                <div class="accordion">
                    <button type="button"><?php echo htmlspecialchars($category['name']); ?></button>
                </div>
                <div class="panel">
                    <?php $products = getProducts($GLOBALS['pdo'], $category['id']); ?>
                    <?php if (empty($products)) : ?>
                        <p>No products available.</p>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="product-item">
                                <div class="product-info">
                                    <h3 id="<?php echo htmlspecialchars('product-' . $product['id']); ?>"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <h4 id="<?php echo htmlspecialchars($product['price']); ?>"><?php echo number_format($product['price'], 2); ?> RSD</h4>
                                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                                </div>
                                <?php if (!empty($_SESSION["logged_in"])): ?>
                                    <div>
                                        <input type="hidden" name="items[<?php echo htmlspecialchars($product['id']); ?>][id]" value="<?php echo htmlspecialchars($product['id']); ?>">
                                        <input type="hidden" name="items[<?php echo htmlspecialchars($product['id']); ?>][name]" value="<?php echo htmlspecialchars($product['name']); ?>">
                                        <input type="hidden" name="items[<?php echo htmlspecialchars($product['id']); ?>][price]" value="<?php echo htmlspecialchars($product['price']); ?>">
                                        <label for="quantity-<?php echo htmlspecialchars($product['id']); ?>">Quantity:</label>
                                        <input type="number" class="qty-input" id="quantity-<?php echo htmlspecialchars($product['id']); ?>" name="items[<?php echo htmlspecialchars($product['id']); ?>][quantity]" value="0" min="0" max="5">
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION["logged_in"])): ?>
            <div class="order-controls">
                <input type="submit" class="btn" value="Place Order" />
                <input type="reset" value="Reset" class="resetBtn" />
            </div>
        <?php endif; ?>
    </section>
</form>
<?php include PROJECT_ROOT . '/templates/footer.php'; ?>
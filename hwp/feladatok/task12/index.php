<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$categories = getCategoriesData();
//$products = getProductsData(['id_product', 'name']);

//var_dump($categories, $products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task 12 - Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
        }

        fieldset {
            margin-bottom: 20px;
            padding: 15px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }

        .form-actions {
            margin-top: 15px;
        }

        .form-actions input {
            margin-right: 10px;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h1>Task 12</h1>

<?php if (!empty($_GET['message'])): ?>
    <div class="message">
        <?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
<?php endif; ?>

<fieldset>
    <legend>Add Product</legend>

    <form action="operation.php" method="post">
        <input type="hidden" name="form_type" value="add_product">

        <label for="name_product">Product name:</label>
        <input type="text" name="name_product" id="name_product" required>

        <label for="id_category">Product category:</label>
        <select name="id_category" id="id_category" required>
            <option value="">-- Select category --</option>
            <?php
            foreach ($categories as $category) {
                echo '<option value="' . $category['id_category'] . '">' . $category['name'] . '</option>';
            }
            ?>
        </select>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" min="0" step="1" required>

        <div class="form-actions">
            <input type="submit" value="Save Product">
            <input type="reset" value="Reset Form">
        </div>
    </form>
</fieldset>

<fieldset>
    <legend>Delete Product</legend>

    <!-- TO DO -->
</fieldset>

</body>
</html>
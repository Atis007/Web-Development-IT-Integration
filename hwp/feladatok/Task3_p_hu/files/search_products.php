<?php
include 'includes/functions.php';
global $pdo;
$name = $_GET['name'] ?? '';
$minPrice = $_GET['min_price'] ?? null;
$maxPrice = $_GET['max_price'] ?? null;
$category = $_GET['category'] ?? 'all';

$minPrice = $minPrice === '' ? null : (int)$minPrice;
$maxPrice = $maxPrice === '' ? null : (int)$maxPrice;

$result = searchProducts($pdo, $name, $minPrice, $maxPrice, $category);
var_dump($result);
$products = $result['products'];
$stats = $result['stats'];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Termékek keresése</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }
        h1 {
            margin-bottom: 20px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            align-items: center;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .search-bar label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .search-group {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 150px;
        }
        .search-bar input,
        .search-bar select {
            padding: 7px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        .search-btn {
            background: #0078ff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            height: 42px;
            align-self: flex-end;
        }
        .search-btn:hover {
            background: #005fcc;
        }

        .content {
            display: flex;
            gap: 25px;
        }

        .stats-box {
            background: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            height: max-content;
        }

        table {
            flex: 1;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Termékek keresése</h1>

<form method="GET" class="search-bar">

    <div class="search-group">
        <label for="name">Terméknév</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars(($_GET['name'] ?? '')) ?>">
    </div>

    <div class="search-group">
        <label for="min_price">Min ár</label>
        <input type="number" id="min_price" name="min_price" step="0.01" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
    </div>

    <div class="search-group">
        <label for="max_price">Max ár</label>
        <input type="number" id="max_price" name="max_price" step="0.01" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
    </div>

    <div class="search-group">
        <label for="category">Kategória</label>
        <select id="category" name="category">
            <option value="all">Összes kategória</option>
            <option value="all" <?= $category === 'all' ? 'selected' : '' ?>>Összes kategória</option>
            <?php
            $categories = getCategoryTypes($pdo);
            foreach ($categories as $catValue): ?>
                <option value="<?= htmlspecialchars($catValue) ?>"
                    <?= $category === $catValue ? 'selected' : '' ?>>
                    <?= htmlspecialchars($catValue) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button class="search-btn" type="submit">Keresés</button>
</form>

<div class="content">

    <div class="stats-box">
        <h3>Eredmények</h3>
        <p><strong>Darabszám:</strong> <?= $stats['count']?></p>
        <p><strong>Legalacsonyabb ár:</strong><?= $stats['min_price']?></p>
        <p><strong>Legmagasabb ár:</strong> <?= $stats['max_price']?></p>
        <p><strong>Átlagár:</strong> <?= number_format($stats['avg_price'], 2)?></p>
    </div>

    <table>
        <tr>
            <th>Termék neve</th>
            <th>Ár</th>
            <th>Kategória</th>
            <th>Leírás</th>
        </tr>
<?php
foreach($products as $product): ?>
<tr>
    <td><?= htmlspecialchars($product['product_name']) ?></td>
    <td><?= htmlspecialchars($product['product_price']) ?> Ft</td>
    <td><?= htmlspecialchars($product['product_category']) ?></td>
    <td><?= htmlspecialchars($product['short_desc']) ?></td>
</tr>
<?php endforeach; ?>
    </table>

</div>

</body>
</html>

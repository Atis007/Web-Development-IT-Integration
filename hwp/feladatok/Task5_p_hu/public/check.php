<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use MyApp\Repository\ProductRepository;
use MyApp\Seeder\ProductSeeder;

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    exit;
}

$seeder = new ProductSeeder();
$repo = new ProductRepository();

$action = $_POST["action"] ?? null;

switch ($action) {
    case 'generate':
        $count = (int) $_POST['size'];
        $products = $seeder->generate($count);
        echo "<h3>Inserted products</h3>";
        echo "<table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>";

        $i=1;
        foreach ($products as $p) {
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>" . $p->name . "</td>";
            echo "<td>" . $p->category . "</td>";
            echo "<td>" . $p->price . "</td>";
            echo "<td>" . $p->amount . "</td>";
            echo "</tr>";
            $i++;
        }
            echo "</tbody>";
        echo "</table>";
        $repo->insertMany($products);
        break;

    case 'list':
        $products = $repo->listAll();
        echo "<h3>Every Product from the Database</h3>";
        echo "<table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>";

        $i=1;
        foreach ($products as $p) {
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>" . $p['name'] . "</td>";
            echo "<td>" . $p['category'] . "</td>";
            echo "<td>" . $p['price'] . "</td>";
            echo "<td>" . $p['amount'] . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</tbody>";
        echo "</table>";
        break;

    case 'search':
        $query = preg_replace('/\s+/', ' ', $_POST["search"]);
        $product = $repo->searchByName($query);
        echo "<h3>Searched product</h3>";
        echo "<table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>";

        $i=1;
        foreach ($product as $p) {
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>" . $p['name'] . "</td>";
            echo "<td>" . $p['category'] . "</td>";
            echo "<td>" . $p['price'] . "</td>";
            echo "<td>" . $p['amount'] . "</td>";
            echo "</tr>";
            $i++;
        }
        echo "</tbody>";
        echo "</table>";
        break;

    case 'delete':
        $products = $repo->listAll();
        echo "<h3>Choose a product you want to delete</h3>";
        echo "<table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>";

        $i=1;
        foreach ($products as $p) {
            $id = (string)$p['id_product'];
            $name = htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8');
            $categ = htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8');
            echo "
        <tr style='cursor:pointer'
            onclick=\"
                if(confirm('Are you sure you want to delete: \\n\\n $name $categ')){
                document.getElementById('delete-form-$id').submit();
                }
                \">
            <td>$i</td>
            <td>$name</td>
            <td>$categ</td>
            <td>{$p['price']}</td>
            <td>{$p['amount']}</td>
        </tr>

        <form id='delete-form-$id' method='post' action='check.php' style='display:none'>
            <input type='hidden' name='action' value='delete_confirm'>
            <input type='hidden' name='id' value='$id'>
        </form>
        ";
            $i++;
        }
        echo "</tbody>";
        echo "</table>";
        break;

    case 'delete_confirm':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if(!$id){
            http_response_code(400);
        }

        $repo->deleteById($id);
        echo "<h3>Product deleted</h3>";
        break;

    default:
        die('Unknown action');
}

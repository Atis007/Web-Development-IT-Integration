<?php
require __DIR__ . '/../vendor/autoload.php';
require '../includes/header.php';

use MyApp\Repository\ProductRepository;
use MyApp\Seeder\ProductSeeder;
/*
	- termékek generálását (pl. 10, 50, 100)
	- termékek listázását
	- keresést név alapján
	- termékek törlését
 */
$seeder = new ProductSeeder();
$repo = new ProductRepository();
?>
<form>
    <fieldset>
        <legend>Generate products</legend>
        <?php
        //$products = $seeder->generate(10);
        //$repo->insertMany($products);
        echo "Ten new products have been created, and inserted to the database.";
        ?>
    </fieldset>

    <fieldset>
        <legend>List products</legend>
        <?php
        $list = $repo->listAll();
        ?>
    </fieldset>

    <fieldset>
        <legend>Search product</legend>
        <?php
        $searchTerm = '';
        $searchedProduct = $repo->searchByName($searchTerm);
        ?>
    </fieldset>

    <fieldset>
        <legend>Delete product</legend>
    </fieldset>
</form>
<?php require '../includes/footer.php';?>

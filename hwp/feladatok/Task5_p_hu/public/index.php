<?php
require __DIR__ . '/../vendor/autoload.php';
require '../includes/header.php';

const NUMBERS_OF_PRODUCTS = [1,2,3,4,5,6,7,8,9,10];
?>
<form method="post" action="check.php">
    <fieldset>
        <legend>Generate products</legend>
        <label for="size">Choose a number to generate:</label>
        <select name="size" id="size">
            <?php foreach(NUMBERS_OF_PRODUCTS as $n): {
                echo '<option value="' . $n . '">' . $n . '</option>';
            }
            endforeach; ?>
        </select>
        <div>
            <input type="hidden" name="action" value="generate">

            <input type="submit" name="sb" id="sb" value="Generate Products">
        </div>
    </fieldset>
</form>

<form method="post" action="check.php">
    <fieldset>
        <legend>List products</legend>
        <p>Click on the button to list all the products from the database</p>
        <div>
            <input type="hidden" name="action" value="list">

            <input type="submit" name="sb" id="sb" value="List Products">
        </div>
    </fieldset>
</form>

<form method="post" action="check.php">
    <fieldset>
        <legend>Search product</legend>
        <div class="row">
            <label for="search">Search for a product:</label>
            <div>
                <input name="search" id="search" type="text" class="w-25" required/>
            </div>
        </div>
        <div class="mt-1">
            <input type="hidden" name="action" value="search">

            <input type="submit" name="sb" id="sb" value="Search Product">
        </div>
    </fieldset>
</form>

<form method="post" action="check.php">
    <fieldset>
        <legend>Delete product</legend>

        <div>
            <input type="hidden" name="action" value="delete">

            <input type="submit" name="sb" id="sb" value="Delete Product">
        </div>
    </fieldset>
</form>
<?php require '../includes/footer.php';?>
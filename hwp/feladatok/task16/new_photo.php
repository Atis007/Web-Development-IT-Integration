<?php
require 'includes/functions.php';

$pdo = $GLOBALS['pdo'];

$categ = listCategories($pdo);

$title="Upload New Photo";
require 'includes/header.php';
?>
<form action="add_photo.php" method="post">
    <div>
        <label for="category"></label>
        <select id="category" name="category_id" required>
            <option value="">-- Choose a Category --</option>
            <?php foreach ($categ as $cat): ?>
                <option value="<?= (int)$cat['id_category'] ?>">
                    <?= htmlspecialchars(ucfirst($cat['name'])) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="desc">Description</label>
        <textarea id="desc" cols="15" rows="5" required></textarea>
    </div>

    <div>
        <label for="if">File:</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
        <input type="file" name="file" id="if" accept="image/jpeg" required><br><br>
        <p><b>Maximum 2MB and only accepts .png!</b></p>
    </div>

    <div>
        <input type="submit" name="sb" id="sb" value="Submit">
        <input type="reset" name="rb" id="rb" value="Reset">
    </div>
</form>
<?php require 'includes/footer.php'; ?>

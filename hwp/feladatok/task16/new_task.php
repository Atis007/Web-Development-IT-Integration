<?php
require_once 'includes/functions.php';
$pdo = $GLOBALS['pdo'];

$title = "New Task";
include 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";

$projects = getProjects($pdo);
?>
    <form action="add_new_task.php" method="POST" class="mt-4">
        <div class="mb-3">
            <select name="selected_project_id" id="projectSelect" class="form-select" required>
                <option value="" selected disabled>-- Válassz a listából --</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?= $project['id_project'] ?>">
                        <?= htmlspecialchars($project['title']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="mb-3">
            <label for="task" class="form-label">Feladat neve</label>
            <input type="text" name="task" id="task" required>
        </div>

        <div class="mb-3">
            <label for="description">Feladat leirasa</label><br>
            <textarea rows="5" cols="40" name="description" id="description" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kuldes</button>
        <button type="reset" class="btn">Torles</button>
    </form>
<?php include 'includes/footer.php';?>
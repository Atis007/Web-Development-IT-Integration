<?php
require_once 'includes/functions.php';
$pdo = $GLOBALS['pdo'];

$title = "Edit Users";
include 'includes/header.php';

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";

$users = getUsers($pdo);
?>
    <form action="update_user.php" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="userSelect" class="form-label">Válassz egy "User" jogú felhasználót:</label>

            <select name="selected_user_id" id="userSelect" class="form-select" required>
                <option value="" selected disabled>-- Válassz a listából --</option>

                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id_user'] ?>">
                        <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Varos</label>
            <input type="text" name="city" id="city" required>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Fizetes</label>
            <input type="number" name="salary" id="salary" required>
        </div>

        <div class="mb-3">
            <label for="passwordReset" class="form-label">Jelszo</label>
            <input type="password" name="passwordReset" id="passwordReset" required minlength="8">
        </div>

        <div class="mb-3">
            <input type="radio" name="isActive" value="active" id="active" checked>
            <label for="active">Active</label><br>

            <input type="radio" name="isActive" value="inactive" id="inactive">
            <label for="inactive">Inactive</label><br>
        </div>

        <div class="mb-3">
            <label for="biography">Biografia</label><br>
            <textarea rows="5" cols="40" name="biography" id="biography"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Szerkesztés</button>
    </form>
<?php include 'includes/footer.php';?>
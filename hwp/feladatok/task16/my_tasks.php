<?php
session_start();
require 'includes/functions.php';
$pdo = $GLOBALS["pdo"];

// Ellenőrizzük, hogy be van-e lépve
if (!isset($_SESSION['id_user'])) {
    redirectFn('login', 'Please login first!');
}

// Lekérjük a bejelentkezett felhasználó feladatait
$myTasks = getMyTasks($pdo, $_SESSION['id_user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h1>My Tasks</h1>

<?php if (empty($myTasks)): ?>
    <p>You have no tasks assigned yet.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($myTasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td><?= htmlspecialchars($task['date_time_added']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
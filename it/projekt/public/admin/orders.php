<?php
declare(strict_types=1);

require __DIR__ . '/../../config/config.php';
require PROJECT_ROOT . '/src/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['logged_in']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: ' . BASE_URL);
    exit;
}

$title = 'Orders Dashboard';
$metaDescription = 'Admin order overview.';
require PROJECT_ROOT . '/templates/header.php';

require './actions/order_actions.php';
?>

<main class="container admin-page">
    <h1>Orders Dashboard</h1>

    <div class="admin-grid">
        <section class="card">
            <h2>Today</h2>
            <p>Orders: <strong><?php echo $todayCount; ?></strong></p>
            <p>Total revenue: <strong><?php echo $todayRevenue; ?></strong></p>
        </section>

        <section class="card">
            <h2>This Week</h2>
            <p>Orders: <strong><?php echo $weekCount; ?></strong></p>
            <p>Total revenue: <strong><?php echo $weekRevenue; ?></strong></p>
        </section>

        <section class="card">
            <h2>Month (<?php echo date('F', mktime(0, 0, 0, $month, 1)); ?>)</h2>
            <p>Orders: <strong><?php echo $monthCount; ?></strong></p>
            <p>Total revenue: <strong><?php echo $monthRevenue; ?></strong></p>
        </section>

        <section class="card">
            <h2>Year (<?php echo $year; ?>)</h2>
            <p>Orders: <strong><?php echo $yearCount; ?></strong></p>
            <p>Total revenue: <strong><?php echo $yearRevenue; ?></strong></p>
        </section>
    </div>
</main>

<?php include PROJECT_ROOT . '/templates/footer.php'; ?>
<?php
require __DIR__ . '/config.php';
require __DIR__ . '/functions.php';

$logs = getLogData($pdo);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Logs</title>
</head>
<body>
<div>
    Legend:
    <span class="phone">phone</span>
    <span class="computer">computer</span>
    <span class="tablet">tablet</span>
</div>
<br>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>User agent</th>
        <th>Ip address</th>
        <th>Country</th>
        <th>Date time</th>
        <th>Device type</th>
        <th>VPN</th>
    </tr>
    </thead>
    <?php $i=1; ?>
    <tbody>
    <?php
    if (!empty($logs)) {
    foreach ($logs as $log): ?>
        <tr class="<?php echo htmlspecialchars($log['device_type']) ?>">
            <td><?php echo $i ?></td>
            <td><?= htmlspecialchars($log['user_agent']) ?></td>
            <td><?= htmlspecialchars($log['ip_address']) ?></td>
            <td><?= htmlspecialchars($log['country']) ?></td>
            <td><?= htmlspecialchars($log['date']) ?></td>
            <td><?= htmlspecialchars($log['device_type']) ?></td>
            <td><?= htmlspecialchars($log['proxy']) ?></td>
        </tr>
        <?php $i++; ?>
    <?php endforeach;
    }
    else {
        echo '<tr><td colspan="8">No logs found.</td></tr>';
    }?>
    </tbody>
</table>
</body>
</html>

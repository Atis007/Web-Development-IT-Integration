<?php
include 'config.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $originalText = $_POST['text'];

    [$original, $modified, $length] = processText($originalText); //destructuring the returned values

    echo "Your text is: $original <br>";

    $pdo = connectDatabase($dsn, $pdoOptions);

    insertData($pdo, $original, $modified, $length);

    $data = getData($pdo);
    echo "The saved data from the database:\n";?>
    <table>
    <thead>
    <tr>
        <th>No</th>
        <th>Original text</th>
        <th>Modified text</th>
        <th>Modified text length</th>
        <th>Date time</th>
    </tr>
    </thead>
    <?php $i=1; ?>
    <tbody>
    <?php foreach ($data as $d): ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?= htmlspecialchars($d['original_text']) ?></td>
            <td><?= htmlspecialchars($d['modified_text']) ?></td>
            <td><?= htmlspecialchars($d['length']) ?></td>
            <td><?= htmlspecialchars($d['date']) ?></td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<?php } else {
    exit("Invalid request");
}?>
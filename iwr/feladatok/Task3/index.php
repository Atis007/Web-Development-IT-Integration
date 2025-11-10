<?php
include 'functions.php';
include 'config.php';
$pdo = connectDatabase($dsn, $pdoOptions);

$dom = new DOMDocument();

$url = 'https://zlatko.stud.vts.su.ac.rs/buep/curl1';
$response = getCurlData($url);

libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$h1 = $xpath->query('//h1');
if ($h1->length > 0) {
    $string= $h1[0]->textContent;
    $name=substr($string, 44, -1);
}

$p = $xpath->query('//p');
if($p->length > 0){
    $string= $p[0]->textContent;
    $number=substr($string, 45);
}

if($name && $number){
    //kikommenteltem hogy ne tegyen minden egyes frissites alkalmaval be uj adatokat
    //insertIntoLog($pdo, $name, $number);
} else {
    echo "No data to insert";
}

$logs = getLogData($pdo);

$logs = getLogData($pdo);
$i = 1;
$title='Task3 - Homepage';
include 'includes/header.php';
echo "<table>";
echo '<tr><th>No</th><th>Random Name</th><th>Random Number</th><th>Date time</th></tr>';

if (!empty($logs)) {
    foreach ($logs as $log) {
        echo '<td>' . $i . '.</td>';
        echo '<td>' . htmlspecialchars($log['random_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($log['random_number'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($log['date'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</td>';
        echo '</tr>';
        $i++;
    }
} else {
    echo '<tr><td colspan="8">No logs found.</td></tr>';
}
echo "</table>";
include 'includes/footer.php';
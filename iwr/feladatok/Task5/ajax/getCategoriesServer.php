<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/functions.php';

$pdo = $GLOBALS['pdo'];

// 1) DataTables parameters
$draw   = (int)($_POST['draw']   ?? 0);
$start  = (int)($_POST['start']  ?? 0);
$length = (int)($_POST['length'] ?? 10);

if ($length === -1) {
    $length = 1000000;
}

$searchValue = $_POST['search']['value'] ?? '';

// 2) Sorting
$orderColumnIndex = (int)($_POST['order'][0]['column'] ?? 0);
$orderDir         = ($_POST['order'][0]['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

$columnMap = [
    0 => 'id_log',  // "No" column – mapped to id_log
    1 => 'ip_address',
    2 => 'user_agent',
    3 => 'date_time',
    4 => 'device_type',
];
$orderColumn = $columnMap[$orderColumnIndex] ?? 'date_time';

// 3) Base SQL parts
$baseSql  = "FROM task2";
$whereSql = "";

// 4) Global search — three separate placeholders
$hasSearch = ($searchValue !== '');
if ($hasSearch) {
    $whereSql = " WHERE CAST(id_log AS CHAR) LIKE :search_id
                 OR ip_address LIKE :search_ip
                 OR user_agent LIKE :search_user
                 OR date_time LIKE :search_date
                 OR device_type LIKE :search_device";
}

// 5) Total number of records (without filtering)
$totalRecordsSql  = "SELECT COUNT(*) " . $baseSql;
$totalRecordsStmt = $pdo->query($totalRecordsSql);
$recordsTotal     = (int)$totalRecordsStmt->fetchColumn();

// 6) Total number of filtered records
if ($hasSearch) {
    $filteredSql  = "SELECT COUNT(*) " . $baseSql . $whereSql;
    $filteredStmt = $pdo->prepare($filteredSql);

    $likeValue = '%' . $searchValue . '%';
    $filteredStmt->bindValue(':search_id', $likeValue, PDO::PARAM_STR);
    $filteredStmt->bindValue(':search_ip', $likeValue, PDO::PARAM_STR);
    $filteredStmt->bindValue(':search_user',   $likeValue, PDO::PARAM_STR);
    $filteredStmt->bindValue(':search_date',   $likeValue, PDO::PARAM_STR);
    $filteredStmt->bindValue(':search_device',   $likeValue, PDO::PARAM_STR);

    $filteredStmt->execute();
    $recordsFiltered = (int)$filteredStmt->fetchColumn();
} else {
    $recordsFiltered = $recordsTotal;
}

// 7) Main SELECT with ORDER BY and LIMIT
$dataSql = "SELECT ip_address, user_agent, date_time, device_type
            $baseSql
            $whereSql
            ORDER BY $orderColumn $orderDir
            LIMIT :start, :length";

$dataStmt = $pdo->prepare($dataSql);

if ($hasSearch) {
    $likeValue = '%' . $searchValue . '%';
    $dataStmt->bindValue(':search_id', $likeValue, PDO::PARAM_STR);
    $dataStmt->bindValue(':search_ip', $likeValue, PDO::PARAM_STR);
    $dataStmt->bindValue(':search_user',   $likeValue, PDO::PARAM_STR);
    $dataStmt->bindValue(':search_date',   $likeValue, PDO::PARAM_STR);
    $dataStmt->bindValue(':search_device',   $likeValue, PDO::PARAM_STR);
}

$dataStmt->bindValue(':start',  $start,  PDO::PARAM_INT);
$dataStmt->bindValue(':length', $length, PDO::PARAM_INT);

$dataStmt->execute();

$rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

// 8) Format data for DataTables
$data   = [];
$number = $start + 1;

foreach ($rows as $row) {
    $data[] = [
        'no'          => $number,
        'ip_address'        => $row['ip_address'],
        'user_agent'    => $row['user_agent'],
        'date_time'    => $row['date_time'],
        'device_type' => $row['device_type'],
    ];
    $number++;
}

// 9) JSON response
echo json_encode([
    'draw'            => $draw,
    'recordsTotal'    => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data'            => $data
], JSON_UNESCAPED_UNICODE);
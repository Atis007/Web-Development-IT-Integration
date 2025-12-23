<?php
require 'includes/functions.php';

$title = "Levenshtein Distance - Check";
include_once 'includes/header.php';

$pdo = $GLOBALS['pdo'];

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php?error=". urlencode("Only POST requests are allowed"));
    exit;
}

$searchedTerm = trim($_POST["searchedTerm"]);

if($searchedTerm === ""){
    header("Location: index.php?error=You must enter a search term!");
    exit;
}

if(mb_strlen($searchedTerm) < 1 || mb_strlen($searchedTerm) > 25){
    header("Location: index.php?error=The search term must be between 1 and 25 characters!");
    exit;
}

// no check -> no min max value, the whole db is searched
// check -> only the words within the min max length range is searched
$useLength = isset($_POST["use_length"]);

if($useLength) {
    // if no check then don't need to search for the min max values
    $min = (int)($_POST["min"] ?? 1);
    $max = (int)($_POST["max"] ?? 21);

    $min = max(1, min(21, $min));
    $max = max(1, min(21, $max));

    if ($min > $max) {
        [$min, $max] = [$max, $min];
    }

    [$distance, $closestWord, $closestWordId, $totalSearchTime, $constraint] = levenshteinDistance($searchedTerm, true, $min, $max);
} else {
    [$distance, $closestWord, $closestWordId, $totalSearchTime, $constraint] = levenshteinDistance($searchedTerm, false);
}

if($distance === -1) {
    echo "<p>No matching word found for the given word.</p>";
    insertIntoResults($pdo, $closestWordId, $searchedTerm, $distance, $totalSearchTime, $constraint);

include_once 'includes/footer.php';

} else {
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8">
                <div class="app-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Result</h5>
                        <span class="badge badge-accent">
                        <?= $constraint === 'used' ? 'With filter' : 'No filter' ?>
                    </span>
                    </div>

                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>Word entered</th>
                            <th>Closest word</th>
                            <th>Levenshtein-distance value</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($searchedTerm) ?></td>
                            <td><?php echo htmlspecialchars($closestWord) ?></td>
                            <td><?php echo htmlspecialchars($distance) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php insertIntoResults($pdo, $closestWordId, $searchedTerm, $distance, $totalSearchTime, $constraint);
}

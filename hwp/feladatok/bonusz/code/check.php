<?php
require 'includes/functions.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php?error=Only POST requests are allowed");
    exit;
}

$searchedTerm = trim($_POST["searchedTerm"]);

if($searchedTerm === ""){
    header("Location: index.php?error=You must enter a search term!");
    exit;
}

if(strlen($searchedTerm) < 1 || strlen($searchedTerm) > 25){
    header("Location: index.php?error=The search term must be between 1 and 25 characters!");
    exit;
}

[$message, $shortest, $lev, $closest] = levenshteinDistance($searchedTerm);
var_dump($message, $shortest, $lev, $closest);
echo "<table>
        <thead>
            <tr>
                <th>Word entered</th>
                <th>Closest word</th>
                <th>Levenshtein-distance value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>" . htmlspecialchars($searchedTerm) . "</td>
                <td>" . htmlspecialchars($closest) . "</td>
                <td>" . htmlspecialchars($lev) . "</td>
            </tr>
        </tbody>
      </table>";


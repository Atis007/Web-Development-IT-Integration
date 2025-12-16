<?php
require 'includes/functions.php';

$title="Task8 - Jokes";
include_once 'includes/header.php';

$pdo = $GLOBALS['pdo'];

$jokes = getLastJokes($pdo);?>
<table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
    <thead style="background: #f2f2f2;">
    <tr>
        <th style="width: 50px;">No</th>
        <th style="text-align: center">Jokes</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach ($jokes as $joke):{
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            if($joke['type'] === 'twopart'){
                echo "<td>" . htmlspecialchars($joke['setup']) . "<br>" . htmlspecialchars($joke['delivery']) . "</td>";
            } else {
                echo "<td>" . $joke['joke'] . "</td>";
            }
            echo "</tr>";
        }
        $i++;
        endforeach;?>
    </tbody>
</table>
<?php include_once 'includes/footer.php';?>
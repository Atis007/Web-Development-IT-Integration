<?php
$title = "Task10 - Task2";
include "includes/header.php";
?>
    <form action="process.php" method="POST" class="p-3">
        <div class="d-flex flex-column w-25 mb-4">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <label for="email" class="mt-1">Email</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div class="d-flex flex-column w-25">
        <label for="date">Date</label>
        <input type="text" name="date" id="date" required></input>
        </div>
        <div class="mt-2">
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </div>
    </form>
<?=include "includes/footer.php";?>
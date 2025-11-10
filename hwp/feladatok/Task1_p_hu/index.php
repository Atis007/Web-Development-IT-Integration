<?php
$title="Homepage";
include 'includes/header.php';
?>
<div class="d-flex justify-content-center mt-5">
    <form action="search.php" method="post">
        <div>
            <label for="search" class="form-label">Search</label><br>
            <textarea class="form-control" id="search" name="search"></textarea>
        </div>
        <div class="mt-2">
            <button type="reset" class="btn">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
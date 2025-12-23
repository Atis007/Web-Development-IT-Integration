<?php
$title = "Levenshtein Distance";
include_once 'includes/header.php';

$lengthArray = range(1, 21); //min and max length characters in the database

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-9">

            <div class="app-card p-4 p-md-5">
                <h2 class="mb-1 text-center">Levenshtein Word Finder</h2>
                <p class="text-muted mb-4">
                    Finds the closest matching word using Levenshtein distance.
                </p>

                <form method="post" action="check.php">

                    <div class="mb-4">
                        <label for="searchedTerm" class="form-label">Enter a word</label>
                        <input class="form-control" id="searchedTerm" type="text" name="searchedTerm" placeholder="Enter word here..." required>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="use_length" id="useLength" onChange="toggleLength(this)">
                        <label class="form-check-label text-muted" for="useLength">
                            Use word length search?
                        </label>
                    </div>

                    <div  id="length-box" style="display:none;">
                        <div class="row g-3 mb-4">
                            <div class="col">
                                <label for="wordMinLength" class="form-label">Min length</label>
                                <select id="wordMinLength" name="min" class="form-select">
                                    <?php foreach ($lengthArray as $n): ?>
                                        <option value="<?php echo htmlspecialchars($n); ?>"><?php echo htmlspecialchars($n); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col">
                                <label for="wordMaxLength" class="form-label">Max length</label>
                                <select id="wordMaxLength" name="max" class="form-select">
                                    <?php foreach ($lengthArray as $n): ?>
                                        <option value="<?php echo htmlspecialchars($n); ?>"><?php echo htmlspecialchars($n); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-row-reverse mt-3 gap-3">
                        <input type="submit" value="Submit" class="btn btn-primary">
                        <input type="reset" value="Reset" class="btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleLength(checkbox) {
        document.getElementById('length-box').style.display = checkbox.checked ? 'block' : 'none'
    }
</script>
<?php include_once 'includes/footer.php';?>

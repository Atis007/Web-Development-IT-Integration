<?php
//guzzle, faker, bootstrap, mobiledetect, qrcode LETOLTENI
$title = "Forms";
require "../includes/header.php";
require "../includes/functions.php";

$workers = getWorkers($GLOBALS['pdo']);

if(isset($_GET['error']))
    echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['error']) . "</p>";
?>
<div class="row">
    <div class="col-3">
        <?php
        if(isset($_GET['postError']))
            echo "<p style='color:red; font-weight: bold'>" . htmlspecialchars($_GET['postError']) . "</p>";
        ?>
        <form method="post" action="../requests.php">
            <h1 class="mb-4"><?= htmlspecialchars($GLOBALS['method'][0]) ?></h1>
            <input type="hidden" name="METHOD" value="<?= htmlspecialchars($GLOBALS['method'][0]) ?>">

            <div class="d-flex flex-column mb-3">
                <label for="name" class="form-label">Name</label>
                <input name="name" id="name" type="text" placeholder="Enter a name" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="job" class="form-label">Job</label>
                <input name="job" id="job" type="text" placeholder="Enter a job" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" id="email" type="email" placeholder="Enter an email" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="phone_number" class="form-label">Phone number</label>
                <input name="phone_number" id="phone_number" type="tel" placeholder="Enter a phone number" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input name="salary" id="salary" type="number" placeholder="Enter a salary" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="company_name" class="form-label">Company</label>
                <input name="company_name" id="company_name" type="text" placeholder="Enter a company name" class="form-control w-75">
            </div>

            <div>
                <input type="submit" name="sb" id="sb" value="Send" class="btn btn-primary">
            </div>
        </form>
    </div>

    <div class="col-3">
        <?php
        if(isset($_GET['patchError']))
            echo "<p style='color:blue; font-weight: bold'>" . htmlspecialchars($_GET['patchError']) . "</p>";
        ?>
        <form method="post" action="../requests.php">
            <h1 class="mb-4"><?= htmlspecialchars($GLOBALS['method'][1]) ?></h1>
            <input type="hidden" name="METHOD" value="<?= htmlspecialchars($GLOBALS['method'][1]) ?>">

            <div class="d-flex flex-column mb-3">
                <label for="worker_id" class="form-label">Worker</label>
                <select name="worker_id" id="worker_id" class="form-select w-75">
                    <option value="0">Choose</option>
                    <?php
                    foreach ($workers as $worker) {
                        echo '<option value="' . $worker['id_worker'] . '">' . $worker['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="worker_new_name" class="form-label">Name</label>
                <input name="worker_new_name" id="worker_new_name" type="text" placeholder="Enter a name" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="worker_new_job" class="form-label">Job</label>
                <input name="worker_new_job" id="worker_new_job" type="text" placeholder="Enter a job" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="worker_new_email" class="form-label">Email</label>
                <input name="worker_new_email" id="worker_new_email" type="email" placeholder="Enter an email" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="worker_new_phone_number" class="form-label">Phone number</label>
                <input name="worker_new_phone_number" id="worker_new_phone_number" type="tel" placeholder="Enter a phone number" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="worker_new_salary" class="form-label">Salary</label>
                <input name="worker_new_salary" id="worker_new_salary" type="number" placeholder="Enter a salary" class="form-control w-75">
            </div>

            <div class="d-flex flex-column mb-3">
                <label for="worker_new_company_name" class="form-label">Company</label>
                <input name="worker_new_company_name" id="worker_new_company_name" type="text" placeholder="Enter a company name" class="form-control w-75">
            </div>

            <div>
                <input type="submit" name="sb" id="sb" value="Send" class="btn btn-primary">
            </div>
        </form>
    </div>
    <div class="col-3">
        <form method="post" action="../requests.php">
            <h1 class="mb-4"><?= htmlspecialchars($GLOBALS['method'][2]) ?></h1>
            <input type="hidden" name="METHOD" value="<?= htmlspecialchars($GLOBALS['method'][2]) ?>">

            <div class="d-flex flex-column mb-3">
                <label for="worker_id" class="form-label">Worker</label>
                <select name="worker_id" id="worker_id" class="form-select w-75">
                    <option value="0">All</option>
                    <?php
                    foreach ($workers as $worker) {
                        echo '<option value="' . $worker['id_worker'] . '">' . $worker['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div>
                <input type="submit" name="sb" id="sb" value="Send" class="btn btn-primary">
            </div>
        </form>
    </div>
    <div class="col-3">
        <img src="../qr_codes/number.png">
    </div>
</div>
<?php require "../includes/footer.php";?>

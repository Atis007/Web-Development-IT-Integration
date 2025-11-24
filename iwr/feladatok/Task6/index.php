<?php
$title = "Task6";
include 'includes/header.php';
?>
    <div class="container mt-5">
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center w-50 mx-auto">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success text-center w-50 mx-auto">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>
        <div class="d-flex justify-content-center text-center">
            <div class="p-4 border-end border-dark">
                <form action="add.php" method="POST">
                    <input type="hidden" name="source" value="phone">

                    <h2>Phone</h2>
                    <label for="phone">Phone:</label><br>
                    <input type="text" name="data" id="phone" required><br>
                    <div class="mt-3">
                        <button type="submit">Send</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>

            <div class="p-4 border-end border-dark">
                <form action="add.php" method="POST">
                    <input type="hidden" name="source" value="sms">

                    <h2>SMS</h2>
                    <label for="sms">Phone:</label><br>
                    <input type="text" name="data" id="sms"><br>

                    <div class="mt-3">
                        <button type="submit">Send</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>

            <div class="p-4 border-end border-dark">
                <form action="add.php" method="POST">
                    <input type="hidden" name="source" value="url">

                    <h2>URL</h2>
                    <label for="url">Url:</label><br>
                    <input type="text" name="data" id="url"><br>

                    <div class="mt-3">
                        <button type="submit">Send</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
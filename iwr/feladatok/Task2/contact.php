<?php
include 'blocked_country.php';
$title = "Contact";
include 'includes/header.php';
?>
<div class="container mt-5 d-flex justify-content-center align-items-center">
    <form action="mail.php" method="post">
        <div class="d-flex gap-2 mb-3 text-center">
            <div>
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" style="width: 160px;">
            </div>
            <div>
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" style="width: 160px;">
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" rows="3" name="message"></textarea>
        </div>
        <button type="reset" class="btn">Reset</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <img src="assets/laptop.jpg" alt="Laptop in dark" style="max-width: 500px; width: 100%; height: auto; border-radius: 6px;">
    </div>

<?php include 'includes/footer.php'; ?>
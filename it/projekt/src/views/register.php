<?php
$title = "Sign Up";
require PROJECT_ROOT . '/templates/header.php';
?>
<div class="container">
    <section class="card login-wrap">
        <h2 style="text-align: center; margin-bottom: 20px;">Sign Up</h2>

        <form action="<?php echo BASE_URL; ?>register-action" method="post" class="login-form">
            <?php
            if (isset($_GET['registerError']))
                echo "<p class=\"error-message\" >" . htmlspecialchars($_GET['registerError']) . "</p>";
            ?>
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" name="fullName" id="fullName" placeholder="Write your full name here..." required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="example@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label for="passwordAgain">Password Again</label>
                <input type="password" name="passwordAgain" id="passwordAgain" placeholder="••••••••" required>
            </div>

            <div class="form-actions">
                <input type="submit" name="sb" id="sb" value="Sign Up" class="btn login-btn">
            </div>

        </form>
    </section>
</div>
<?php include PROJECT_ROOT . '/templates/footer.php'; ?>
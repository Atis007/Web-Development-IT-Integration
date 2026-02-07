<?php
$title = "Login";
require PROJECT_ROOT . '/templates/header.php';
?>
    <div class="container">
        <section class="card login-wrap">
            <h2 style="text-align: center; margin-bottom: 20px;">Login</h2>

            <form action="<?php echo BASE_URL; ?>login-action" method="post" class="login-form">
                <?php
                if(isset($_GET['loginError']))
                    echo "<p class=\"error-message\" >" . htmlspecialchars($_GET['loginError']) . "</p>";
                ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="example@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>

                <div class="form-actions">
                    <input type="submit" name="sb" id="sb" value="Login" class="btn login-btn">
                </div>

            </form>
        </section>
    </div>
<?php include PROJECT_ROOT . '/templates/footer.php'; ?>
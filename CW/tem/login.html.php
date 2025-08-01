<div class="auth-form-container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <p>Don't have an account? <a href="signup.php" style="color: #00796B;">Sign Up</a></p>
    </div>
</div>
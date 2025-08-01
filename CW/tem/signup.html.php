<div class="auth-form-container">
    <h2>Create Account</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" 
                   value="<?= htmlspecialchars($name ?? '') ?>" 
                   required maxlength="100">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   value="<?= htmlspecialchars($email ?? '') ?>" 
                   required maxlength="255">
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" 
                   required minlength="6" maxlength="255">
            <small style="color: #666;">Password must be at least 6 characters</small>
        </div>
        
        <div class="form-actions">
            <input type="submit" value="Sign Up" class="btn-primary">
            <p style="text-align: center; margin-top: 15px;">
                Already have an account? 
                <a href="login.php" style="color: #00796B; font-weight: bold;">Login here</a>
            </p>
        </div>
    </form>
</div>
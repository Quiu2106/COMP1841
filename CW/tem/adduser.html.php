<div class="auth-form-container">
    <h2>Add New User</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $messageType ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <label for="name">Name: *</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        
        <label for="email">Email: *</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        
        <label for="password">Password: *</label>
        <input type="password" id="password" name="password" minlength="6" required>
        <small>Password must be at least 6 characters long</small>
        
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="user" <?= ($_POST['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= ($_POST['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        
        <input type="submit" value="Add User">
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        <a href="user.php">← Back to Users</a>
    </p>
</div>
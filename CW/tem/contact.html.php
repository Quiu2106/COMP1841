<div class="auth-form-container" style="max-width: 600px; margin: 40px auto;">
    <h2>Contact Us</h2>
    <p style="text-align: center; margin-bottom: 30px; color: #666;">
        Have a question or need help? Send us a message and we'll get back to you as soon as possible.<br>
        <small>Messages will be sent to: <strong>Admin</strong></small>
    </p>

    <?php if (!empty($message)): ?>
        <div class="alert <?= $messageType === 'success' ? 'alert-success' : 'alert-error' ?>" style="margin-bottom: 20px;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div style="margin-bottom: 15px;">
            <label for="name">Your Name: <span style="color: red;">*</span></label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email">Your Email: <span style="color: red;">*</span></label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="subject">Subject: <span style="color: red;">*</span></label>
            <select id="subject" name="subject" required>
                <option value="">Select a subject...</option>
                <option value="General Question" <?= ($subject ?? '') === 'General Question' ? 'selected' : '' ?>>General Question</option>
                <option value="Technical Support" <?= ($subject ?? '') === 'Technical Support' ? 'selected' : '' ?>>Technical Support</option>
                <option value="Bug Report" <?= ($subject ?? '') === 'Bug Report' ? 'selected' : '' ?>>Bug Report</option>
                <option value="Feature Request" <?= ($subject ?? '') === 'Feature Request' ? 'selected' : '' ?>>Feature Request</option>
                <option value="Other" <?= ($subject ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="message">Message: <span style="color: red;">*</span></label>
            <textarea id="message" name="message" rows="6" required style="resize: vertical;" placeholder="Please describe your question or issue in detail..."><?= htmlspecialchars($messageContent ?? '') ?></textarea>
        </div>

        <div style="text-align: center;">
            <input type="submit" value="Send Message" style="background-color: #00796B; padding: 12px 30px;">
        </div>
    </form>
</div>

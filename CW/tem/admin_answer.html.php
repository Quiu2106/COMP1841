<div class="admin-answer-container">
    <div class="answer-header">
        <h2>Reply to Contact Message</h2>
        <a href="admin_mess.php" class="btn-back">← Back to Messages</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="message-details-card">
        <div class="original-message">
            <div class="message-header-info">
                <h3>Original Message</h3>
                <div class="message-status">
                    <span class="status-badge <?= $message['is_read'] ? 'read' : 'unread' ?>">
                        <?= $message['is_read'] ? 'Read' : 'Unread' ?>
                    </span>
                </div>
            </div>
            
            <div class="sender-details">
                <div class="detail-row">
                    <label>From:</label>
                    <span class="sender-name"><?= htmlspecialchars($message['name']) ?></span>
                </div>
                <div class="detail-row">
                    <label>Email:</label>
                    <span class="sender-email"><?= htmlspecialchars($message['email']) ?></span>
                </div>
                <div class="detail-row">
                    <label>Date:</label>
                    <span class="message-date"><?= date('F j, Y \a\t g:i A', strtotime($message['created_at'])) ?></span>
                </div>
                <div class="detail-row">
                    <label>Subject:</label>
                    <span class="message-subject"><?= htmlspecialchars($message['subject']) ?></span>
                </div>
            </div>
            
            <div class="message-content">
                <label>Message:</label>
                <div class="message-text">
                    <?= nl2br(htmlspecialchars($message['message'])) ?>
                </div>
            </div>
        </div>

        <?php if (!empty($existingReplies)): ?>
            <div class="existing-replies-section">
                <h3>Previous Replies</h3>
                <?php foreach ($existingReplies as $reply): ?>
                    <div class="reply-item">
                        <div class="reply-header">
                            <strong><?= htmlspecialchars($reply['admin_name']) ?></strong>
                            <span class="reply-date"><?= date('M j, Y g:i A', strtotime($reply['sent_at'])) ?></span>
                        </div>
                        <div class="reply-content">
                            <?= nl2br(htmlspecialchars($reply['reply_text'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="reply-form-section">
        <h3><?= !empty($existingReplies) ? 'Send Another Reply' : 'Send Reply' ?></h3>
        
        <form method="post" class="admin-reply-form">
            <div class="form-group">
                <label for="reply_text">Your Reply:</label>
                <textarea 
                    name="reply_text" 
                    id="reply_text" 
                    rows="8" 
                    placeholder="Type your reply here... This will be sent to <?= htmlspecialchars($message['email']) ?>"
                    required
                ><?= isset($_POST['reply_text']) ? htmlspecialchars($_POST['reply_text']) : '' ?></textarea>
                <div class="char-counter">
                    <span id="char-count">0</span> characters
                </div>
            </div>

            <div class="email-preview">
                <h4>Email Preview:</h4>
                <div class="preview-box">
                    <div class="preview-header">
                        <strong>To:</strong> <?= htmlspecialchars($message['email']) ?><br>
                        <strong>Subject:</strong> Re: <?= htmlspecialchars($message['subject']) ?><br>
                        <strong>From:</strong> <?= SITE_NAME ?> Admin
                    </div>
                    <div class="preview-content" id="preview-content">
                        <p>Dear <?= htmlspecialchars($message['name']) ?>,</p>
                        <p>Thank you for contacting us. Here is our response to your message:</p>
                        <div class="preview-reply-text" id="preview-reply-text">
                            [Your reply will appear here...]
                        </div>
                        <p>Best regards,<br><?= htmlspecialchars($adminName) ?><br><?= SITE_NAME ?></p>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-send-reply">
                    <i class="icon-send"></i>
                    Send Reply Email
                </button>
                <a href="admin_mess.php" class="btn-cancel">Cancel</a>
                
                <div class="action-note">
                    <small>
                        <i class="icon-info"></i>
                        This will send an email to <?= htmlspecialchars($message['email']) ?> and save the reply in the system.
                    </small>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const replyTextarea = document.getElementById('reply_text');
    const charCount = document.getElementById('char-count');
    const previewReplyText = document.getElementById('preview-reply-text');
    
    // Character counter and live preview
    replyTextarea.addEventListener('input', function() {
        const text = this.value;
        charCount.textContent = text.length;
        
        // Update preview
        if (text.trim()) {
            previewReplyText.innerHTML = text.replace(/\n/g, '<br>');
        } else {
            previewReplyText.textContent = '[Your reply will appear here...]';
        }
    });
    
    // Auto-resize textarea
    replyTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // Confirmation before sending
    document.querySelector('.admin-reply-form').addEventListener('submit', function(e) {
        const replyText = replyTextarea.value.trim();
        if (replyText.length < 10) {
            e.preventDefault();
            alert('Reply must be at least 10 characters long.');
            return;
        }
        
        if (!confirm('Are you sure you want to send this reply email?')) {
            e.preventDefault();
        }
    });
});
</script>
<div class="admin-messages-container">
    <div class="messages-header">
        <h2>Contact Messages</h2>
        <div class="message-stats">
            <span class="total-messages">Total: <?= count($messages) ?></span>
            <?php if ($unreadCount > 0): ?>
                <span class="unread-badge"><?= $unreadCount ?> unread</span>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($messages)): ?>
        <div class="no-messages">
            <p>No contact messages yet.</p>
            <small>Messages from the contact form will appear here.</small>
        </div>
    <?php else: ?>
        <div class="messages-list">
            <?php foreach ($messages as $msg): ?>
                <div class="message-card <?= $msg['is_read'] ? 'read' : 'unread' ?>">
                    <div class="message-header">
                        <div class="message-info">
                            <h3 class="message-subject"><?= htmlspecialchars($msg['subject']) ?></h3>
                            <p class="message-from">
                                From: <strong><?= htmlspecialchars($msg['name']) ?></strong> 
                                (<?= htmlspecialchars($msg['email']) ?>)
                            </p>
                        </div>
                        <div class="message-date">
                            <?= date('M j, Y', strtotime($msg['created_at'])) ?><br>
                            <small><?= date('g:i A', strtotime($msg['created_at'])) ?></small>
                        </div>
                    </div>
                    
                    <div class="message-content">
                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                    </div>
                    
                    <div class="message-actions">
                        <a href="admin_answer.php?id=<?= $msg['id'] ?>" class="btn-reply">Reply</a>
                        <?php if (!$msg['is_read']): ?>
                            <a href="?mark_read=<?= $msg['id'] ?>" class="btn-mark-read">Mark as Read</a>
                        <?php else: ?>
                            <span class="read-status">✓ Read</span>
                        <?php endif; ?>
                        
                        <a href="?delete=<?= $msg['id'] ?>" class="btn-delete" 
                           onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

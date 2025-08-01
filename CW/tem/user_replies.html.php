<div class="user-replies-container">
    <h2>Admin Replies</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($replies)): ?>
        <p>No replies from admin yet.</p>
    <?php else: ?>
        <ul class="replies-list">
            <?php foreach ($replies as $reply): ?>
                <li class="reply-item">
                    <div class="reply-header">
                        <h3>Subject: <?= htmlspecialchars($reply['subject']) ?></h3>
                        <p><strong>Admin:</strong> <?= htmlspecialchars($reply['admin_name']) ?></p>
                        <p><strong>Sent:</strong> <?= date('F j, Y, g:i A', strtotime($reply['sent_at'])) ?></p>
                    </div>
                    <div class="reply-content">
                        <p><strong>Your Message:</strong></p>
                        <p><?= nl2br(htmlspecialchars($reply['message'])) ?></p>
                        <p><strong>Admin Reply:</strong></p>
                        <p><?= nl2br(htmlspecialchars($reply['reply_text'])) ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
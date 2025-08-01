<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .email-container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #00796B; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .reply-box { background: white; padding: 15px; border-left: 4px solid #00796B; margin: 15px 0; }
        .original-box { background: #e8e8e8; padding: 15px; margin: 15px 0; }
        .footer { background: #37474F; color: white; padding: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2><?= SITE_NAME ?> - Admin Reply</h2>
        </div>
        
        <div class="content">
            <p>Dear <?= htmlspecialchars($originalMessage['name']) ?>,</p>
            <p>Thank you for contacting us. We have received your message and here is our response:</p>
            
            <div class="reply-box">
                <h4>Admin Response:</h4>
                <p><?= nl2br(htmlspecialchars($replyText)) ?></p>
                <p><em>- <?= htmlspecialchars($adminName) ?></em></p>
            </div>
            
            <div class="original-box">
                <h4>Your Original Message:</h4>
                <p><strong>Subject:</strong> <?= htmlspecialchars($originalMessage['subject']) ?></p>
                <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($originalMessage['message'])) ?></p>
                <p><strong>Sent:</strong> <?= $originalMessage['created_at'] ?></p>
            </div>
            
            <p>If you have any further questions, please feel free to contact us again.</p>
        </div>
        
        <div class="footer">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
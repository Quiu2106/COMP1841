<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
        <p>Someone sent you a message from <?= htmlspecialchars(SITE_NAME) ?></p>
    </div>
    
    <div class="content">
        <div class="info-row">
            <span class="label">From:</span>
            <strong><?= htmlspecialchars($name) ?></strong>
        </div>
        
        <div class="info-row">
            <span class="label">Email:</span>
            <a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a>
        </div>
        
        <div class="info-row">
            <span class="label">Subject:</span>
            <?= htmlspecialchars($subject) ?>
        </div>
        
        <div class="info-row">
            <span class="label">Message:</span>
        </div>
        
        <div class="message-box">
            <?= nl2br(htmlspecialchars($message)) ?>
        </div>
        
        <div class="timestamp">
            Received: <?= date('M j, Y \a\t g:i A') ?>
        </div>
    </div>
    
    <div class="footer">
        <p>This email was automatically generated from the contact form on <?= htmlspecialchars(SITE_NAME) ?></p>
        <p>Please reply directly to <?= htmlspecialchars($email) ?> to respond to this message.</p>
    </div>
</body>
</html>
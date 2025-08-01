<?php
// Email configuration constants
define('ADMIN_EMAIL', 'quinngcs230163@fpt.edu.vn');
define('SITE_NAME', 'COMP1841 Coursework');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-smtp-username@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');

class EmailService {
    
    /**
     * Send contact form email to admin
     */
    public static function sendContactEmail($name, $email, $subject, $message) {
        $emailSubject = '[' . SITE_NAME . '] Contact Form: ' . $subject;
        $emailBody = self::getContactEmailHtml($name, $email, $subject, $message);
        
        $headers = "From: " . SITE_NAME . " <noreply@comp1841.local>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        return mail(ADMIN_EMAIL, $emailSubject, $emailBody, $headers);
    }
    
    /**
     * Generate HTML email template
     */
    private static function getContactEmailHtml($name, $email, $subject, $message) {
        ob_start();
        include __DIR__ . '/../tem/email_contact_template.html.php';
        return ob_get_clean();
    }
    
    /**
     * Validate email configuration
     */
    public static function isConfigured() {
        return defined('ADMIN_EMAIL') && !empty(ADMIN_EMAIL);
    }
    
    /**
     * Get admin email for display
     */
    public static function getAdminEmail() {
        return ADMIN_EMAIL;
    }
    
    /**
     * Get site name
     */
    public static function getSiteName() {
        return SITE_NAME;
    }
}
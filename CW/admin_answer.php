<?php
session_start();
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
include 'emailconfig.php';

// Check admin permissions
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Check if message ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = 'Message ID not provided.';
    header('Location: admin_mess.php');
    exit;
}

$messageId = $_GET['id'];
$adminId = $_SESSION['user_id'];
$adminName = $_SESSION['name'] ?? 'Admin';

try {
    // Get the original message
    $message = getContactMessageById($pdo, $messageId);
    if (!$message) {
        throw new Exception('Message not found.');
    }

    // Process reply form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['reply_text']) && !empty(trim($_POST['reply_text']))) {
            try {
                $successMessage = processAdminReply($pdo, $messageId, $_POST['reply_text'], $adminId, $adminName);
                $_SESSION['success_message'] = $successMessage;
                header('Location: admin_mess.php');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = 'Reply message cannot be empty.';
        }
    }

    // Get existing replies for this message
    $existingReplies = getAdminReplies($pdo, $messageId);

    // Mark message as read when viewing
    if (!$message['is_read']) {
        markContactMessageAsRead($pdo, $messageId);
    }

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: admin_mess.php');
    exit;
}

$title = 'Reply to Message';
ob_start();
include 'tem/admin_answer.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
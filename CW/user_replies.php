<?php
session_start();
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Lấy các phản hồi từ admin dành cho user
    $stmt = $pdo->prepare("
        SELECT cm.subject, cm.message, ar.reply_text, ar.sent_at, u.name as admin_name
        FROM admin_replies ar
        JOIN contact_messages cm ON ar.message_id = cm.id
        JOIN user u ON ar.admin_id = u.id
        WHERE cm.email = (SELECT email FROM user WHERE id = ?)
        ORDER BY ar.sent_at DESC
    ");
    $stmt->execute([$userId]);
    $replies = $stmt->fetchAll();
} catch (Exception $e) {
    $error = $e->getMessage();
}

$title = 'Admin Replies';
ob_start();
include 'tem/user_replies.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
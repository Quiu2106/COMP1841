<?php
session_start();
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Mark message as read
if (isset($_GET['mark_read'])) {
    markMessageAsRead($pdo, $_GET['mark_read']);
    header('Location: admin_mess.php');
    exit;
}

// Delete message
if (isset($_GET['delete'])) {
    deleteContactMessage($pdo, $_GET['delete']);
    header('Location: admin_mess.php');
    exit;
}

// Get all messages using function
$messages = getAllContactMessages($pdo);

// Count unread messages using function
$unreadCount = getUnreadMessagesCount($pdo);

$title = 'Contact Messages';
ob_start();
include 'tem/admin_mess.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
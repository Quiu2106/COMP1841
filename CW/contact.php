<?php
session_start();
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = $_POST['subject'] ?? '';
    $messageContent = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($messageContent)) {
        $message = 'All fields are required.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'error';
    } else {
        // Lưu vào database thay vì gửi email
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$name, $email, $subject, $messageContent])) {
            $message = 'Your message has been sent successfully! We will get back to you soon.';
            $messageType = 'success';
            $name = $email = $subject = $messageContent = '';
        } else {
            $message = 'Sorry, there was an error. Please try again.';
            $messageType = 'error';
        }
    }
}

$title = 'Contact Us';
ob_start();
include 'tem/contact.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'includ/DatabaseConnection.php';
require_once 'includ/DatabaseFunction.php';

$userId = $_SESSION['user_id'];
$user = getUserById($pdo, $userId);

// Kiểm tra quyền truy cập - cho phép cả user và admin
$userRole = $_SESSION['role'] ?? 'user';
if (!in_array($userRole, ['user', 'admin'])) {
    header("Location: login.php");
    exit;
}

$totalUserQuestions = totalQuestionsByUser($pdo, $userId);
$userQuestions = getQuestionsByUser($pdo, $userId);
$userStats = getUserStats($pdo, $userId);

// Tính tổng số câu hỏi của user
$totalUserQuestions = count($userQuestions);

// Lấy comments nếu cần
$userComments = [];
if (isset($_GET['show']) && $_GET['show'] === 'comments') {
    $userComments = getCommentsByUser($pdo, $userId);
}

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $message = processProfileUpdate($pdo, $userId, $_POST, $_FILES);
        
        // Cập nhật session
        $_SESSION['name'] = trim($_POST['name']);
        $_SESSION['email'] = trim($_POST['email']);
        
        $_SESSION['profile_message'] = $message;
    } catch (Exception $e) {
        $_SESSION['profile_error'] = $e->getMessage();
    }
    
    header("Location: profile.php");
    exit;
}

$title = "Profile";
ob_start();
include 'tem/profile.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
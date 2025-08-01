<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

// Cho phép guest xem questions
$isGuest = !isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;
$userRole = $_SESSION['role'] ?? 'guest';

// Display messages if any
$message = $_SESSION['message'] ?? '';
$messageType = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

try {
    $title = 'Questions';
    $allQuestions = getAllQuestions($pdo);
    $totalQuestions = totalQuestions($pdo);
    $questions = [];
    
    foreach ($allQuestions as $question) {
        // Guest không có quyền edit/delete
        if ($isGuest) {
            $canEdit = false;
            $canDelete = false;
        } else {
            // Chỉ chủ sở hữu mới có quyền edit bài của mình
            $canEdit = ($question['user_id'] == $userId);
            // Admin có thể delete tất cả, user chỉ delete bài của mình
            $canDelete = canDeleteQuestion($pdo, $question['id'], $userId, $userRole);
        }
        
        $questions[] = [
            'id' => $question['id'],
            'title' => $question['title'],
            'text' => nl2br(htmlspecialchars($question['text'])),
            'date' => $question['date'],
            'image' => $question['image'],
            'username' => $question['username'],
            'module_name' => $question['module_name'] ?? 'No Module',
            'can_edit' => $canEdit,
            'can_delete' => $canDelete,
            'is_guest' => $isGuest // Thêm flag để template biết
        ];
    }
    
    ob_start();
    include 'tem/ques.html.php';
    $output = ob_get_clean();
    
    // Chỉ admin mới thấy statistics
    if ($userRole === 'admin') {
        $output = '<p style="color: #00796B; font-weight: bold;">Total Questions: ' . $totalQuestions . ' questions have been posted.</p>' . $output;
    }
    
    // Thông báo cho guest
    if ($isGuest) {
        $guestNotice = '<div class="alert alert-info">
            <strong>Guest Mode:</strong> You are viewing as a guest. 
            <a href="login.php" style="color: #0c5460; font-weight: bold;">Login</a> to post questions and comments, or 
            <a href="signup.php" style="color: #0c5460; font-weight: bold;">Sign up</a> for a new account.
        </div>';
        $output = $guestNotice . $output;
    }
    
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';
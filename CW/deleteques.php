<?php
session_start();
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $questionId = $_POST['id'];
    $userId = $_SESSION['user_id'];
    $userRole = $_SESSION['role'] ?? 'user';
    
    try {
        // Kiểm tra quyền delete
        $question = getQuestionById($pdo, $questionId);
        if (!$question) {
            throw new Exception('Question not found.');
        }
        
        // Chỉ admin hoặc author mới có thể xóa
        if ($userRole !== 'admin' && $question['user_id'] != $userId) {
            throw new Exception('You do not have permission to delete this question.');
        }
        
        // Thực hiện cascade delete
        cascadeDeleteQuestion($pdo, $questionId);
        
        $_SESSION['message'] = 'Question deleted successfully!';
        $_SESSION['message_type'] = 'success';
        
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error deleting question: ' . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: ques.php');
exit;
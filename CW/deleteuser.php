<?php
session_start();
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'], $_POST['id'])) {
    $userId = $_POST['id'];
    $currentUserId = $_SESSION['user_id'];
    
    try {
        // Sử dụng function từ DatabaseFunction.php
        if (!canDeleteUser($pdo, $userId, $currentUserId)) {
            if ($userId == $currentUserId) {
                throw new Exception('You cannot delete your own account.');
            } elseif (isLastAdmin($pdo, $userId)) {
                throw new Exception('Cannot delete the last admin user.');
            } else {
                throw new Exception('You do not have permission to delete this user.');
            }
        }
        
        // Thực hiện cascade delete
        cascadeDeleteUser($pdo, $userId);
        
        $_SESSION['message'] = 'User deleted successfully!';
        $_SESSION['message_type'] = 'success';
        
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error deleting user: ' . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }
}

header('Location: user.php');
exit;
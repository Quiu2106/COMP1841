<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment_text'] ?? '');
    $questionId = $_POST['question_id'] ?? null;
    $userId = $_SESSION['user_id'] ?? null;
    $date = date('Y-m-d H:i:s');

    if ($comment !== '' && $questionId && $userId) {
        addComment($pdo, $questionId, $userId, $comment, $date);
    }
    header("Location: comment.php?id=" . $questionId);
    exit;
}

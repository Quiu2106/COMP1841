<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['id'] ?? null;
    if ($comment_id) {
        $question_id = getCommentQuestionId($pdo, $comment_id);
        deleteComment($pdo, $comment_id);
        header("Location: comment.php?id=" . $question_id);
        exit;
    }
}

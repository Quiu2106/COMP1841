<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_GET['id'])) {
    die('No comment ID specified.');
}

try {
    $title = 'Edit Comment';

    // Xử lý cập nhật comment
    if (isset($_POST['comment_text'], $_GET['id'])) {
        updateComment($pdo, $_GET['id'], $_POST['comment_text']);
        $_SESSION['message'] = 'Comment updated successfully.';
        // Lấy lại question_id để chuyển hướng về trang comment
        $question_id = getCommentQuestionId($pdo, $_GET['id']);
        header('location: comment.php?id=' . $question_id);
        exit;
    }

    // Lấy dữ liệu comment
    $comment = getCommentById($pdo, $_GET['id']);
    if (!$comment) {
        throw new Exception('Comment not found');
    }

    ob_start();
    include 'tem/editcomment.html.php';
    $output = ob_get_clean();
} catch (Exception $e) {
    $title = 'Error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';
<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();


if (!isset($_GET['id'])) {
    die('No question ID specified.');
}
$questionId = $_GET['id'];
$question = getQuestionById($pdo, $questionId);
$comments = getCommentsByQuestion($pdo, $questionId);
$userName = getUserById($pdo, $question['user_id']);

$title = 'Post & Comments';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['login_message'] = 'You must login to comment!';
        header('Location: login.php');
        exit;
    }
}
ob_start();
include 'tem/comment.html.php';
$output = ob_get_clean();

include 'tem/layout.html.php';

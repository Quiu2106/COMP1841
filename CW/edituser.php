<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';  
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try {
    $title = 'Edit User';

    if (isset($_POST['name'], $_POST['email'], $_POST['id'])) {
        updateUser($pdo, $_POST);
        header('location: user.php');
        exit;
    }

    if (!isset($_GET['id'])) {
        throw new Exception('No user ID provided');
    }
    $user = getUserById($pdo, $_GET['id']);
    $userData = [
        'id' => $user['id'],
        'name' => htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'),
        'email' => htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')
    ];

    ob_start();
    include 'tem/edituser.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';

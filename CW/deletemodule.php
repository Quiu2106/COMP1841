<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try {
    if (isset($_POST['id'])){
    deleteModule($pdo, $_POST['id']);
    } else {
        throw new Exception('Module ID not provided.');
    }

    header('location: module.php');
    exit;
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error deleting module: ' . $e->getMessage();
    include 'tem/layout.html.php';
}

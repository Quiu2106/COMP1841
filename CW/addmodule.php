<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try{
    $title = 'Add New Module';

    if (isset($_POST['name'])) {
        addModule($pdo, $_POST);
        header('location: module.php');
        exit;
    }

    ob_start();
    include 'tem/addmodule.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}
include 'tem/layout.html.php';
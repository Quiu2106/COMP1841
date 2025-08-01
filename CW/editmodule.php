<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try {
    $title = 'Edit Module';

    if (isset($_POST['name'])) {
        updateModule($pdo, $_POST);
        $_SESSION['message'] = 'Module updated successfully.';
        header('location: module.php');
        exit;
    }
    if (!isset($_GET['id'])) {
        throw new Exception('No module ID provided');
    }
    $m = getModuleById($pdo, $_GET['id']);
    $moduleData = [
        'id' => $m['id'],
        'name' => htmlspecialchars($m['name'], ENT_QUOTES, 'UTF-8')
    ];


    ob_start();
    include 'tem/editmodule.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}
include 'tem/layout.html.php';
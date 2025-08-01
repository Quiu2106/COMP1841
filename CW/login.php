<?php
require 'includ/Databaseconnection.php';
require 'includ/DatabaseFunction.php';
session_start();

$error = '';

// Chỉ lấy thông báo từ session nếu chưa submit form
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !empty($_SESSION['login_message'])) {
    $error = $_SESSION['login_message'];
    unset($_SESSION['login_message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        if (login($pdo, $email, $password)) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong email or password.";
        }
    } else {
        $error = "Please enter email and password.";
    }
}

$title = 'Login';
ob_start();
include 'tem/login.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
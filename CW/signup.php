<?php
require 'includ/Databaseconnection.php';
require 'includ/DatabaseFunction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif (isEmailTaken($pdo, $email)) {
        $errors[] = "Email already exists.";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    
    if (empty($errors)) {
        try {
            signup($pdo, $name, $email, $password);
            $_SESSION['message'] = 'Account created successfully! Please login.';
            $_SESSION['message_type'] = 'success';
            header('Location: login.php');
            exit;
        } catch (Exception $e) {
            $errors[] = 'Registration failed: ' . $e->getMessage();
        }
    }
}

$title = 'Sign Up';
ob_start();
include 'tem/signup.html.php';
$output = ob_get_clean();
include 'tem/layout.html.php';
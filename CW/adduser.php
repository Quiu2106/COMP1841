<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

try {
    $title = 'Add New User';
    $message = '';
    $messageType = '';

    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $role = $_POST['role'] ?? 'user';
        
        // Validation
        if (empty($name) || empty($email) || empty($password)) {
            $message = 'All fields are required.';
            $messageType = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Please enter a valid email address.';
            $messageType = 'error';
        } elseif (strlen($password) < 6) {
            $message = 'Password must be at least 6 characters long.';
            $messageType = 'error';
        } elseif (isEmailTaken($pdo, $email)) {
            $message = 'Email address already exists.';
            $messageType = 'error';
        } else {
            // Hash password và tạo user data
            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role
            ];
            
            // Gọi function addUser với password
            addUserWithPassword($pdo, $userData);
            header('location: user.php?success=User added successfully');
            exit;
        }
    }

    ob_start();
    include 'tem/adduser.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';
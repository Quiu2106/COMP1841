<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $title = 'Add New Question';
    $imageName = null;
    
    if (isset($_FILES['question_image']) && $_FILES['question_image']['error'] === 0) {
        $targetDir = "images/";
        $imageName = time() . '_' . basename($_FILES["question_image"]["name"]);
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES["question_image"]["tmp_name"], $targetFile);
        $_POST['image'] = $imageName;
    }

    if (isset($_POST['title'], $_POST['text'], $_POST['user_id'], $_POST['module_id'])) {
        // Xử lý module_id - nếu chọn "No info" thì set NULL
        $moduleId = $_POST['module_id'] ?? null;
        if ($moduleId == '0' || $moduleId == '') {
            $moduleId = null;
        }
        
        $_POST['image'] = $_POST['image'] ?? null;
        $_POST['module_id'] = $moduleId; // Sử dụng moduleId đã xử lý
        addQuestion($pdo, $_POST);
        header('Location: ques.php');
        exit;
    }
    
    $user = getLoggedInUser($pdo);
    if (!$user) {
        throw new Exception('User not found');
    }
    $userName = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');

    // Lấy dữ liệu dropdown modules
    $modules = $pdo->query('SELECT * FROM module')->fetchAll();

    // Tạo dropdown option với "No info" đầu tiên
    $moduleOptions = '';
    
    // Thêm option "No info" đầu tiên
    $moduleOptions .= '<option value="0">No info</option>';
    
    // Thêm các module có sẵn
    foreach ($modules as $module) {
        $moduleOptions .= '<option value="' . $module['id'] . '">' .
                          htmlspecialchars($module['name']) . '</option>';
    }

    ob_start();
    include 'tem/addques.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';
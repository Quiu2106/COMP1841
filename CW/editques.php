<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $title = 'Edit Question';

    if (!isset($_GET['id'])) {
        throw new Exception('No question ID provided');
    }

    $question = getQuestionById($pdo, $_GET['id']);
    if (!$question) {
        throw new Exception('Question not found');
    }

    // Xử lý khi submit form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Xử lý module_id - nếu chọn "No info" thì set NULL
        $moduleId = $_POST['module_id'] ?? null;
        if ($moduleId == '0' || $moduleId == '') {
            $moduleId = null;
        }
        
        // Xử lý upload ảnh mới
        $imageName = $question['image'];
        if (isset($_FILES['question_image']) && $_FILES['question_image']['error'] === 0) {
            $targetDir = "images/";
            $imageName = time() . '_' . basename($_FILES["question_image"]["name"]);
            $targetFile = $targetDir . $imageName;
            move_uploaded_file($_FILES["question_image"]["tmp_name"], $targetFile);
        }
        
        // Chuẩn bị dữ liệu cập nhật
        $updateData = [
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'text' => $_POST['text'],
            'user_id' => $_SESSION['user_id'],
            'module_id' => $moduleId,
            'image' => $imageName
        ];
        updateQuestion($pdo, $updateData);
        header('location: ques.php');
        exit;
    }

    // Tạo dropdown module với option "No info"
    $modules = $pdo->query('SELECT * FROM module')->fetchAll();
    $moduleOptions = '';
    
    // Kiểm tra module_id có tồn tại và không null
    $currentModuleId = $question['module_id'] ?? null;
    
    // Thêm option "No info" đầu tiên
    $selectedNone = (empty($currentModuleId) || $currentModuleId == '0') ? 'selected' : '';
    $moduleOptions .= '<option value="0" ' . $selectedNone . '>No info</option>';
    
    // Thêm các module có sẵn
    foreach ($modules as $module) {
        $selected = ($module['id'] == $currentModuleId) ? 'selected' : '';
        $moduleOptions .= '<option value="' . $module['id'] . '" ' . $selected . '>' .
                          htmlspecialchars($module['name']) . '</option>';
    }
    
    // Chuẩn bị dữ liệu cho form
    $questionData = [
        'id' => $question['id'],
        'title' => htmlspecialchars($question['title'] ?? '', ENT_QUOTES, 'UTF-8'),
        'text' => htmlspecialchars($question['text'] ?? '', ENT_QUOTES, 'UTF-8'),
        'image' => !is_array($question['image']) ? htmlspecialchars($question['image'] ?? '', ENT_QUOTES, 'UTF-8') : '',
        'moduleOptions' => $moduleOptions
    ];
    $user = getUserById($pdo, $_SESSION['user_id']);
    $userName = $user['name'];

    ob_start();
    include 'tem/editques.html.php';
    $output = ob_get_clean();
} catch (Exception $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';
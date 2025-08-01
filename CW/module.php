<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$role = $_SESSION['role'] ?? 'user';
try {
    $title = 'Module List';
    $result = getModules($pdo);
    if (!$result) {
        throw new PDOException('No users found.');
    }
    $modules = [];
    foreach ($result as $row) {
        $edit_link = '';
        $delete_form = '';
        if ($role === 'admin') {
            $edit_link = '<a href="editmodule.php?id=' . $row['id'] . '" class="btn-edit">Edit</a>';
            $delete_form = '<form action="deletemodule.php" method="post" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this module?\')">
                    <input type="hidden" name="id" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">
                    <input type="submit" name="delete" value="🗑️ Delete" class="btn-delete">
                  </form>';
        }
        $modules[] = [
            'name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'),
            'edit_link' => $edit_link,
            'delete_form' => $delete_form,
        ];
    }

    ob_start();
    include 'tem/module.html.php';
    $output = ob_get_clean();
    if ($role === 'admin') {
        $output = '<p style="color: #00796B; font-weight: bold;">Total Modules: ' . count($modules) . ' modules have been registered.</p>' . $output;
    }
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error fetching modules: ' . $e->getMessage();
}

include 'tem/layout.html.php';


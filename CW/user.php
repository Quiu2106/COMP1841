<?php
include 'includ/DatabaseConnection.php';
include 'includ/DatabaseFunction.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$myid = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'user';

// Hiển thị message nếu có
$message = $_SESSION['message'] ?? '';
$messageType = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

// Xử lý cập nhật role nếu admin submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role']) && $role === 'admin') {
    try {
        $userId = $_POST['user_id'];
        $newRole = $_POST['new_role'];
        
        // Kiểm tra không được tự hạ quyền mình
        if ($userId == $_SESSION['user_id'] && $newRole !== 'admin') {
            throw new Exception('You cannot remove your own admin privileges.');
        }
        
        updateUserRole($pdo, $userId, $newRole);
        $_SESSION['message'] = 'User role updated successfully!';
        $_SESSION['message_type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error updating role: ' . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }
    header('Location: user.php');
    exit;
}

try {
    $title = 'User List';
    $result = getAllUsers($pdo);
    
    if (!$result) {
        throw new PDOException('No users found.');
    }
    
    $users = [];
    foreach ($result as $row) {
        $isAdmin = $role === 'admin';
        $delete_form = '';
        $role_form = '';
        
        if ($isAdmin) {
            // Không cho phép xóa chính mình
            $canDelete = ($row['id'] != $_SESSION['user_id']);
            
            if ($canDelete) {
                $delete_form = '<form action="deleteuser.php" method="post" style="display:inline;" 
                                      onsubmit="return confirm(\'Are you sure you want to delete this user? This will also delete all their questions and comments.\')">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">
                        <input type="submit" name="delete" value="🗑️ Delete" class="btn-delete">
                      </form>';
            } else {
                $delete_form = '<span class="btn-disabled">Cannot delete yourself</span>';
            }
            
            // Form cấp quyền cho admin (không cho phép tự hạ quyền mình)
            $canChangeRole = ($row['id'] != $_SESSION['user_id']);
            
            if ($canChangeRole) {
                $role_form = '<form method="post" style="display:inline;">
                        <input type="hidden" name="user_id" value="' . $row['id'] . '">
                        <select name="new_role" onchange="this.form.submit()">
                            <option value="user"' . ($row['role'] === 'user' ? ' selected' : '') . '>User</option>
                            <option value="admin"' . ($row['role'] === 'admin' ? ' selected' : '') . '>Admin</option>
                        </select>
                        <input type="hidden" name="update_role" value="1">
                      </form>';
            } else {
                $role_form = '<span class="current-role">' . ucfirst($row['role']) . ' (You)</span>';
            }
        }

        $users[] = [
            'name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'),
            'email' => htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'),
            'role' => htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8'),
            'delete_form' => $delete_form,
            'role_form' => $role_form,
        ];
    }
    
    ob_start();
    include 'tem/user.html.php';
    $output = ob_get_clean();
    
    if ($role === 'admin') {
        $output = '<p style="color: #00796B; font-weight: bold;">Total Users: ' . count($users) . ' users have been registered.</p>' . $output;
    }
    
} catch (PDOException $e) {
    $title = 'Database error';
    $output = 'Error: ' . $e->getMessage();
}

include 'tem/layout.html.php';
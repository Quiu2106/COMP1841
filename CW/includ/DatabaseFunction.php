<?php
/* ==============================================
   📊 STATISTICS & ANALYTICS
   ============================================== */

// ========== BASIC STATISTICS ==========
function totalQuestions($pdo) { 
    return $pdo->query('SELECT COUNT(*) FROM question')->fetchColumn(); 
}

function totalUsers($pdo) { 
    return $pdo->query('SELECT COUNT(*) FROM user')->fetchColumn(); 
}

function totalModules($pdo) { 
    return $pdo->query('SELECT COUNT(*) FROM module')->fetchColumn(); 
}

function totalQuestionsByUser($pdo, $userId) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM question WHERE user_id = :uid');
    $stmt->execute([':uid' => $userId]);
    return $stmt->fetchColumn();
}

function getUserStats($pdo, $userId) {
    return [
        'total_questions' => totalQuestionsByUser($pdo, $userId),
        'total_comments' => $pdo->prepare('SELECT COUNT(*) FROM comment WHERE user_id = ?')->execute([$userId]) ? $pdo->query('SELECT COUNT(*) FROM comment WHERE user_id = ' . $userId)->fetchColumn() : 0
    ];
}

/* ==============================================
   ❓ QUESTION MANAGEMENT SYSTEM
   ============================================== */

// ========== QUESTION RETRIEVAL ==========
function getAllQuestions($pdo) {
    $sql = 'SELECT question.id, question.title, question.text, question.date, question.image,
                   user.name AS username, module.name AS module_name, question.user_id
            FROM question
            LEFT JOIN user ON question.user_id = user.id
            LEFT JOIN module ON question.module_id = module.id
            ORDER BY question.date DESC';
    return $pdo->query($sql)->fetchAll();
}

function getQuestion($pdo, $id) {
    $stmt = $pdo->prepare('SELECT question.id, question.title, question.text, question.date, question.image,
                                  user.name AS username, module.name AS module_name, question.user_id
                           FROM question
                           LEFT JOIN user ON question.user_id = user.id
                           LEFT JOIN module ON question.module_id = module.id
                           WHERE question.id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function getQuestionById($pdo, $id) { 
    return getQuestion($pdo, $id); 
}

function getQuestionsByUser($pdo, $userId) {
    $stmt = $pdo->prepare('SELECT * FROM question WHERE user_id = :uid ORDER BY date DESC');
    $stmt->execute([':uid' => $userId]);
    return $stmt->fetchAll();
}

// ========== QUESTION CRUD OPERATIONS ==========
function addQuestion($pdo, $data) {
    $stmt = $pdo->prepare('INSERT INTO question (title, text, user_id, module_id, image, date)
                           VALUES (:title, :text, :user_id, :module_id, :image, CURDATE())');
    $stmt->execute([':title' => $data['title'], ':text' => $data['text'], ':user_id' => $data['user_id'],
                    ':module_id' => $data['module_id'], ':image' => $data['image']]);
}

function updateQuestion($pdo, $data) {
    $stmt = $pdo->prepare('UPDATE question SET title = :title, text = :text, user_id = :user_id,
                           module_id = :module_id, image = :image WHERE id = :id');
    $stmt->execute([':title' => $data['title'], ':text' => $data['text'], ':user_id' => $data['user_id'],
                    ':module_id' => $data['module_id'], ':image' => $data['image'], ':id' => $data['id']]);
}

function deleteQuestion($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM question WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

// ========== QUESTION PERMISSIONS & VALIDATION ==========
function canDeleteQuestion($pdo, $questionId, $userId, $userRole) {
    $question = getQuestionById($pdo, $questionId);
    if (!$question) return false;
    
    // Admin có thể xóa bất kỳ question nào
    if ($userRole === 'admin') return true;
    
    // User chỉ có thể xóa question của mình
    return $question['user_id'] == $userId;
}

function cascadeDeleteQuestion($pdo, $questionId) {
    try {
        $pdo->beginTransaction();
        
        // 1. Xóa tất cả comments của question này trước
        $stmt = $pdo->prepare("DELETE FROM comment WHERE question_id = ?");
        $stmt->execute([$questionId]);
        
        // 2. Xóa question
        $stmt = $pdo->prepare("DELETE FROM question WHERE id = ?");
        $stmt->execute([$questionId]);
        
        $pdo->commit();
        return true;
        
    } catch (Exception $e) {
        $pdo->rollback();
        throw new Exception('Database error during question deletion: ' . $e->getMessage());
    }
}

/* ==============================================
   💬 COMMENT MANAGEMENT SYSTEM
   ============================================== */

// ========== COMMENT RETRIEVAL ==========
function getCommentsByQuestion($pdo, $question_id) {
    $stmt = $pdo->prepare("SELECT c.id, c.user_id, c.text, u.name AS username
                           FROM comment c JOIN user u ON c.user_id = u.id
                           WHERE c.question_id = :id ORDER BY c.date ASC");
    $stmt->execute([':id' => $question_id]);
    return $stmt->fetchAll();
}

function getCommentById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM comment WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function getCommentsByUser($pdo, $userId) {
    $stmt = $pdo->prepare('SELECT c.*, q.title FROM comment c JOIN question q ON c.question_id = q.id WHERE c.user_id = :uid ORDER BY c.date DESC');
    $stmt->execute([':uid' => $userId]);
    return $stmt->fetchAll();
}

function getCommentQuestionId($pdo, $comment_id) {
    $stmt = $pdo->prepare("SELECT question_id FROM comment WHERE id = :id");
    $stmt->execute([':id' => $comment_id]);
    $row = $stmt->fetch();
    return $row ? $row['question_id'] : null;
}

// ========== COMMENT CRUD OPERATIONS ==========
function addComment($pdo, $questionId, $userId, $text, $date) {
    $stmt = $pdo->prepare("INSERT INTO comment (text, question_id, user_id, date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$text, $questionId, $userId, $date]);
}

function updateComment($pdo, $id, $text) {
    $stmt = $pdo->prepare("UPDATE comment SET text = :text WHERE id = :id");
    $stmt->execute([':text' => $text, ':id' => $id]);
}

function deleteComment($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM comment WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

/* ==============================================
   📚 MODULE MANAGEMENT SYSTEM
   ============================================== */

// ========== MODULE RETRIEVAL ==========
function getModules($pdo) { 
    return $pdo->query('SELECT id, name FROM module ORDER BY name')->fetchAll(); 
}

function getModuleById($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM module WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

// ========== MODULE CRUD OPERATIONS ==========
function addModule($pdo, $data) {
    $stmt = $pdo->prepare('INSERT INTO module (name) VALUES (:name)');
    $stmt->execute([':name' => $data['name']]);
}

function updateModule($pdo, $data) {
    $stmt = $pdo->prepare('UPDATE module SET name = :name WHERE id = :id');
    $stmt->execute([':name' => $data['name'], ':id' => $data['id']]);
}

function deleteModule($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM module WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

/* ==============================================
   👥 USER MANAGEMENT SYSTEM
   ============================================== */

// ========== USER RETRIEVAL ==========
function getUser() { 
    global $pdo; 
    return $pdo->query('SELECT * FROM user ORDER BY name')->fetchAll(); 
}

function getAllUsers($pdo) { 
    return $pdo->query('SELECT * FROM user ORDER BY name')->fetchAll(); 
}

function getUserById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getLoggedInUser($pdo) {
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) throw new Exception("User not logged in");
    $user = getUserById($pdo, $userId);
    if (!$user) throw new Exception("User not found");
    return $user;
}

function getAllAdmins($pdo) {
    $stmt = $pdo->prepare("SELECT id, name, email FROM user WHERE role = 'admin' ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll();
}

// ========== USER CRUD OPERATIONS ==========
function addUserWithPassword($pdo, $data) {
    $sql = 'INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, :role)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'], 
        ':password' => $data['password'],
        ':role' => $data['role']
    ]);
}

function addUser($pdo, $data) {
    if (isset($data['password'])) {
        // Với password
        $sql = 'INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, :role)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':role' => $data['role'] ?? 'user'
        ]);
    } else {
        // Không có password (giữ nguyên cho backward compatibility)
        $sql = 'INSERT INTO user (name, email) VALUES (:name, :email)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':name' => $data['name'], ':email' => $data['email']]);
    }
}

function updateUser($pdo, $data) {
    $stmt = $pdo->prepare('UPDATE user SET name = :name, email = :email WHERE id = :id');
    $stmt->execute([':name' => $data['name'], ':email' => $data['email'], ':id' => $data['id']]);
}

function deleteUser($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM user WHERE id = :id');
    $stmt->execute([':id' => $id]);
}

function updateUserRole($pdo, $userId, $role) {
    $stmt = $pdo->prepare("UPDATE user SET role = ? WHERE id = ?");
    return $stmt->execute([$role, $userId]);
}

// ========== USER VALIDATION & PERMISSIONS ==========
function getAdminCount($pdo, $excludeUserId = null) {
    if ($excludeUserId) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE role = 'admin' AND id != ?");
        $stmt->execute([$excludeUserId]);
    } else {
        $stmt = $pdo->query("SELECT COUNT(*) FROM user WHERE role = 'admin'");
    }
    return $stmt->fetchColumn();
}

function getUserRole($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT role FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
}

function isLastAdmin($pdo, $userId) {
    $userRole = getUserRole($pdo, $userId);
    if ($userRole !== 'admin') return false;
    
    $adminCount = getAdminCount($pdo, $userId);
    return $adminCount === 0;
}

function canDeleteUser($pdo, $userId, $currentUserId) {
    // Không thể xóa chính mình
    if ($userId == $currentUserId) return false;
    
    // Không thể xóa admin cuối cùng
    if (isLastAdmin($pdo, $userId)) return false;
    
    return true;
}

function canChangeUserRole($pdo, $userId, $currentUserId, $newRole) {
    // Không thể tự hạ quyền mình
    if ($userId == $currentUserId && $newRole !== 'admin') return false;
    
    return true;
}

function isEmailTaken($pdo, $email, $excludeUserId = null) {
    $sql = "SELECT COUNT(*) FROM user WHERE email = :email";
    $params = [':email' => $email];
    
    if ($excludeUserId) { 
        $sql .= " AND id != :user_id"; 
        $params[':user_id'] = $excludeUserId; 
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn() > 0;
}

// ========== CASCADE DELETE USER ==========
function cascadeDeleteUser($pdo, $userId) {
    try {
        $pdo->beginTransaction();
        
        // 1. Delete admin replies của user này
        $stmt = $pdo->prepare("DELETE FROM admin_replies WHERE admin_id = ?");
        $stmt->execute([$userId]);
        
        // 2. Lấy danh sách questions của user để xóa comments của những questions đó
        $stmt = $pdo->prepare("SELECT id FROM question WHERE user_id = ?");
        $stmt->execute([$userId]);
        $questionIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // 3. Xóa comments của user trên tất cả questions
        $stmt = $pdo->prepare("DELETE FROM comment WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // 4. Xóa comments trên questions của user này (từ users khác)
        if (!empty($questionIds)) {
            $placeholders = str_repeat('?,', count($questionIds) - 1) . '?';
            $stmt = $pdo->prepare("DELETE FROM comment WHERE question_id IN ($placeholders)");
            $stmt->execute($questionIds);
            
            // 5. Xóa questions của user
            $stmt = $pdo->prepare("DELETE FROM question WHERE user_id = ?");
            $stmt->execute([$userId]);
        }
        
        // 6. Update contact_messages - set user_id thành NULL thay vì xóa
        $stmt = $pdo->prepare("UPDATE contact_messages SET user_id = NULL WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // 7. Cuối cùng xóa user
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$userId]);
        
        $pdo->commit();
        return true;
        
    } catch (Exception $e) {
        $pdo->rollback();
        throw new Exception('Database error during user deletion: ' . $e->getMessage());
    }
}

function softDeleteUser($pdo, $userId) {
    // Alternative: Soft Delete (Recommended)
    // Thêm column deleted_at nếu chưa có
    // ALTER TABLE user ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;
    
    $stmt = $pdo->prepare("UPDATE user SET deleted_at = NOW() WHERE id = ?");
    return $stmt->execute([$userId]);
}

/* ==============================================
   🔐 AUTHENTICATION SYSTEM
   ============================================== */

// ========== LOGIN & SIGNUP ==========
function login($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

function signup($pdo, $name, $email, $password) {
    // Check if email already exists
    if (isEmailTaken($pdo, $email)) {
        throw new Exception("Email already exists.");
    }
    
    // Insert new user with default role 'user'
    $stmt = $pdo->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, 'user')");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    if (!$stmt->execute([$name, $email, $hashedPassword])) {
        throw new Exception("Failed to create account.");
    }
    
    return true;
}

/* ==============================================
   👤 PROFILE MANAGEMENT SYSTEM
   ============================================== */

// ========== AVATAR UPLOAD ==========
function uploadAvatar($file, $targetDir = "images/") {
    if (!isset($file) || $file['error'] !== 0) return false;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) throw new Exception("Invalid file type. Only JPG, PNG, GIF allowed.");
    if ($file['size'] > 5 * 1024 * 1024) throw new Exception("File too large. Maximum 5MB allowed.");
    $imageName = time() . '_' . basename($file["name"]);
    $targetFile = $targetDir . $imageName;
    if (move_uploaded_file($file["tmp_name"], $targetFile)) return $imageName;
    throw new Exception("Failed to upload avatar.");
}

// ========== PROFILE VALIDATION ==========
function validateProfileData($name, $email, $password = '') {
    $errors = [];
    if (empty(trim($name))) $errors[] = "Name is required.";
    if (empty(trim($email))) $errors[] = "Email is required.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (!empty($password) && strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    return $errors;
}

// ========== PROFILE UPDATE OPERATIONS ==========
function updateUserProfile($pdo, $id, $name, $email, $image = null) {
    $query = "UPDATE user SET name = :name, email = :email";
    if ($image !== null) $query .= ", image = :image";
    $query .= " WHERE id = :id";
    $params = ['name' => $name, 'email' => $email, 'id' => $id];
    if ($image !== null) $params['image'] = $image;
    return $pdo->prepare($query)->execute($params);
}

function updateUserFull($pdo, $id, $name, $email, $hashedPassword, $image) {
    $stmt = $pdo->prepare("UPDATE user SET name = ?, email = ?, password = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $email, $hashedPassword, $image, $id]);
}

function processProfileUpdate($pdo, $userId, $postData, $fileData) {
    $name = trim($postData['name'] ?? '');
    $email = trim($postData['email'] ?? '');
    $password = $postData['password'] ?? '';
    $errors = validateProfileData($name, $email, $password);
    if (isEmailTaken($pdo, $email, $userId)) $errors[] = "Email already taken by another user.";
    if (!empty($errors)) throw new Exception(implode(' ', $errors));
    $currentUser = getUserById($pdo, $userId);
    $imageName = $currentUser['image'];
    if (isset($fileData['avatar'])) {
        try {
            $uploadedImage = uploadAvatar($fileData['avatar']);
            if ($uploadedImage) {
                if ($imageName && file_exists("images/" . $imageName)) unlink("images/" . $imageName);
                $imageName = $uploadedImage;
            }
        } catch (Exception $e) { throw new Exception("Avatar upload failed: " . $e->getMessage()); }
    }
    if (!empty($password)) {
        updateUserFull($pdo, $userId, $name, $email, password_hash($password, PASSWORD_DEFAULT), $imageName);
        return 'Password and profile updated successfully!';
    } else {
        updateUserProfile($pdo, $userId, $name, $email, $imageName);
        return 'Profile updated successfully!';
    }
}

/* ==============================================
   📧 CONTACT MESSAGE MANAGEMENT
   ============================================== */

// ========== MESSAGE RETRIEVAL ==========
function getAllContactMessages($pdo) {
    $stmt = $pdo->query("SELECT cm.*, u.name as sender_username 
                         FROM contact_messages cm 
                         LEFT JOIN user u ON cm.user_id = u.id 
                         ORDER BY cm.created_at DESC");
    return $stmt->fetchAll();
}

function getContactMessageById($pdo, $messageId) {
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
    $stmt->execute([$messageId]);
    return $stmt->fetch();
}

function getUnreadMessagesCount($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = FALSE");
    return $stmt->fetchColumn();
}

// ========== MESSAGE STATUS OPERATIONS ==========
function markContactMessageAsRead($pdo, $messageId) {
    $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = TRUE WHERE id = ?");
    return $stmt->execute([$messageId]);
}

function markMessageAsRead($pdo, $messageId) {
    $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = TRUE WHERE id = ?");
    return $stmt->execute([$messageId]);
}

function deleteContactMessage($pdo, $messageId) {
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
    return $stmt->execute([$messageId]);
}

// ========== ADMIN NOTIFICATION ==========
function notifyAdminsNewMessage($pdo, $messageId) {
    $admins = getAllAdmins($pdo);
    $message = getContactMessageById($pdo, $messageId);
    
    foreach ($admins as $admin) {
        // Có thể gửi notification email đến các admin
        // hoặc tạo notification system trong database
    }
}

/* ==============================================
   🔄 ADMIN REPLY SYSTEM
   ============================================== */

// ========== REPLY MANAGEMENT ==========
function saveAdminReply($pdo, $originalMessageId, $adminId, $replyText) {
    $stmt = $pdo->prepare("INSERT INTO admin_replies (message_id, admin_id, reply_text, sent_at) VALUES (?, ?, ?, NOW())");
    return $stmt->execute([$originalMessageId, $adminId, $replyText]);
}

function getAdminReplies($pdo, $messageId) {
    $stmt = $pdo->prepare("SELECT ar.*, u.name as admin_name FROM admin_replies ar JOIN user u ON ar.admin_id = u.id WHERE ar.message_id = ? ORDER BY ar.sent_at ASC");
    $stmt->execute([$messageId]);
    return $stmt->fetchAll();
}

// ========== EMAIL GENERATION ==========
function generateReplyEmailHtml($originalMessage, $replyText, $adminName) {
    ob_start();
    include __DIR__ . '/../tem/admin_reply_email.html.php';
    return ob_get_clean();
}

function sendReplyEmail($pdo, $messageId, $replyText, $adminName) {
    $message = getContactMessageById($pdo, $messageId);
    if (!$message) throw new Exception('Original message not found.');
    
    // Lấy email của user gửi message gốc
    if ($message['user_id']) {
        $sender = getUserById($pdo, $message['user_id']);
        $recipientEmail = $sender['email'];
    } else {
        // Fallback nếu không có user_id (tin nhắn cũ)
        $recipientEmail = $message['email'];
    }
    
    $subject = 'Re: ' . $message['subject'];
    $emailBody = generateReplyEmailHtml($message, $replyText, $adminName);
    
    $headers = "From: " . SITE_NAME . " <noreply@comp1841.local>\r\n";
    $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    return mail($recipientEmail, $subject, $emailBody, $headers);
}

// ========== REPLY PROCESSING ==========
function processAdminReply($pdo, $messageId, $replyText, $adminId, $adminName) {
    if (empty(trim($replyText))) throw new Exception('Reply message cannot be empty.');
    if (strlen(trim($replyText)) < 10) throw new Exception('Reply must be at least 10 characters long.');
    if (!saveAdminReply($pdo, $messageId, $adminId, $replyText)) throw new Exception('Failed to save reply.');
    try { sendReplyEmail($pdo, $messageId, $replyText, $adminName); } 
    catch (Exception $e) { error_log('Email sending failed: ' . $e->getMessage()); }
    markContactMessageAsRead($pdo, $messageId);
    return 'Reply sent successfully!';
}
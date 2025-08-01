<div class="profile-container" style="max-width:950px;margin:auto;padding:40px 32px;background:#f9f9f9;border-radius:16px;box-shadow:0 4px 16px #e0e0e0;">
  <div style="display:flex;align-items:flex-start;gap:0;">
    <!-- Avatar bên trái -->
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
      <h2 style="font-size:2.5em;margin-bottom:24px;text-align:center;">User Profile</h2>
      <img src="images/<?= htmlspecialchars($user['image'] ?? 'default-avatar.png') ?>" width="210" height="210" style="border-radius:50%;border:4px solid #43ea7c;margin-bottom:18px;">
      <h3 style="font-size:1.2em;margin-bottom:0;">Current Avatar</h3>
    </div>

    <!-- Thông tin form ở giữa -->
    <div style="flex:2;padding:0 36px;">
      <?php if (!empty($_SESSION['profile_message'])): ?>
        <div class="alert-success" style="background:#00AA00;color:#fff;padding:14px 20px;border-radius:8px;margin-bottom:24px;font-size:1.15em;text-align:center;">
          <?= $_SESSION['profile_message']; ?>
        </div>
        <?php unset($_SESSION['profile_message']); ?>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data" class="profile-form">
        <label style="font-size:1.15em;">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required style="width:100%;margin-bottom:18px;padding:12px;font-size:1.15em;border-radius:8px;border:1px solid #ccc;">

        <label style="font-size:1.15em;">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required style="width:100%;margin-bottom:18px;padding:12px;font-size:1.15em;border-radius:8px;border:1px solid #ccc;">

        <label style="font-size:1.15em;">Change Password (optional):</label>
        <input type="password" name="password" placeholder="Leave blank to keep current" style="width:100%;margin-bottom:18px;padding:12px;font-size:1.15em;border-radius:8px;border:1px solid #ccc;">

        <label style="font-size:1.15em;">Upload New Avatar:</label>
        <input type="file" name="avatar" style="margin-bottom:24px;font-size:1.1em;">
        
        <!-- Nút Save ở giữa dưới cùng -->
        <div style="width:100%;display:flex;justify-content:center;">
          <button type="submit" class="btn-comment" style="background:#00796B;color:#fff;padding:16px 48px;border:none;border-radius:10px;font-size:1.25em;cursor:pointer;margin-top:10px;">Save Changes</button>
        </div>
      </form>
    </div>

    <!-- Tổng số bài và link bên phải + danh sách show trong ô đỏ -->
    <div style="flex:1;display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-start;padding-left:24px;min-width:260px;">
      <div style="font-size:1.2em;margin-bottom:18px;">
        <strong>Total questions posted:</strong> <?= $totalUserQuestions ?>
      </div>
      <a href="profile.php?show=questions" style="color:#00796B;font-weight:bold;font-size:1.1em;margin-bottom:12px;">View my questions</a>
      <a href="profile.php?show=comments" style="color:#00796B;font-weight:bold;font-size:1.1em;">View my comment history</a>

      <?php if (isset($_GET['show']) && $_GET['show'] === 'questions'): ?>
        <div style="background:#fff;border-radius:10px;padding:16px;margin-top:18px;width:100%;">
          <h3 style="margin-top:0;font-size:1.1em;">My Questions</h3>
          <?php if ($userQuestions): ?>
            <ul style="padding-left:18px;font-size:1em;">
              <?php foreach ($userQuestions as $q): ?>
                <li style="margin-bottom:8px;">
                  <a href="comment.php?id=<?= $q['id'] ?>" style="color:#00796B;font-weight:bold;">
                    <?= htmlspecialchars($q['title']) ?>
                  </a>
                  <span style="color:#888;">(<?= $q['date'] ?>)</span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p style="color:#888;">You haven't posted any questions yet.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['show']) && $_GET['show'] === 'comments'): ?>
        <div style="background:#fff;border-radius:10px;padding:16px;margin-top:18px;width:100%;">
          <h3 style="margin-top:0;font-size:1.1em;">My Comment History</h3>
          <?php if ($userComments): ?>
            <ul style="padding-left:18px;font-size:1em;">
              <?php foreach ($userComments as $cmt): ?>
                <li style="margin-bottom:8px;">
                  On <a href="comment.php?id=<?= $cmt['question_id'] ?>" style="color:#00796B;font-weight:bold;"><?= htmlspecialchars($cmt['title']) ?></a>:
                  <?= htmlspecialchars($cmt['text']) ?> <span style="color:#888;">(<?= $cmt['date'] ?>)</span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p style="color:#888;">You haven't commented on any questions yet.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
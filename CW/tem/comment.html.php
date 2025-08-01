<div class="question-card">
  <div class="question-title"><?= htmlspecialchars($question['title']) ?></div>
  <div class="question-module">Module: <?= htmlspecialchars($question['module_name']) ?></div>

  <?php if (!empty($question['image'])): ?>
    <div class="question-image">
      <img src="images/<?= htmlspecialchars($question['image']) ?>" alt="Question Image">
    </div>
  <?php endif; ?>

  <div class="question-text"><?= $question['text'] ?></div>
  <div class="question-meta">
    Posted by <strong><?= htmlspecialchars($question['username']) ?></strong> | <?= $question['date'] ?>
  </div>

  <hr>
  <div class="comment-section">
    <h3>Comments</h3>

    <?php $currentUser = $_SESSION['user_id'] ?? null; ?>
    <?php foreach ($comments as $cmt): ?>
      <div class="comment-box">
        <strong><?= htmlspecialchars($cmt['username']) ?>:</strong> <?= htmlspecialchars($cmt['text']) ?>
        <div style="margin-top: 4px;">
          <?php
            $isOwner = $currentUser == $cmt['user_id'];
            $isPostAuthor = $currentUser == $question['user_id'];
          ?>
          <?php if ($isOwner): ?>
            <a href="editcomment.php?id=<?= $cmt['id'] ?>" class="btn-edit" style="font-size: 0.8em;">✏️ Edit</a>
          <?php endif; ?>
          <?php if ($isOwner || $isPostAuthor): ?>
            <form action="deletecomment.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this comment?')">
              <input type="hidden" name="id" value="<?= $cmt['id'] ?>">
              <input type="submit" value="🗑️ Delete" class="btn-delete" style="font-size: 0.8em;">
            </form>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (empty($comments)): ?>
      <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>
  </div>
</div>

<!-- FORM COMMENT -->
<div class="comment-form" style="margin-top: 20px;">
  <?php $loggedIn = isset($_SESSION['user_id']); ?>
  <form method="post" action="<?= $loggedIn ? 'addcomment.php' : 'login.php?redirected=comment' ?>">
    <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
    <input type="text" name="comment_text" placeholder="Write a comment..." required
           style="width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #ccc;">
    <input type="submit" value="💬 Send" class="btn-submit-comment">
  </form>
</div>
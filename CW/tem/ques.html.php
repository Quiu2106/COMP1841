<?php foreach ($questions as $q): ?>
  <div class="question-card">
    <div class="question-title"><?= htmlspecialchars($q['title']) ?></div>
    <div class="question-module">Module: <?= htmlspecialchars($q['module_name']) ?></div>

<?php if (!empty($q['image'])): ?>
  <div class="question-image">
    <img src="images/<?= htmlspecialchars($q['image']) ?>" alt="Question Image"
         style="max-width: 100%; height: auto; object-fit: contain; border-radius: 8px;">
  </div>
<?php endif; ?>


    <div class="question-text"><?= $q['text'] ?></div>

    <div class="question-footer">
      <div>Posted by <strong><?= htmlspecialchars($q['username']) ?></strong> | <?= $q['date'] ?></div>
      <div class="actions">
        <a href="comment.php?id=<?= $q['id'] ?>" class="btn-comment">💬 Comment</a>
        <?php if (!empty($q['can_edit'])): ?>
          <a href="editques.php?id=<?= $q['id'] ?>" class="btn-edit">✏️ Edit</a>
        <?php endif; ?>
        <?php if (!empty($q['can_delete'])): ?>
          <form action="deleteques.php" method="post" style="display:inline;" 
          onsubmit="return confirm('Are you sure you want to delete this question? This will also delete all comments.')">
            <input type="hidden" name="id" value="<?= $q['id'] ?>">
            <input type="submit" value="🗑️ Delete" class="btn-delete">
          </form>
        <?php endif; ?>
      </div>
    </div>
    <!-- COMMENT SECTION -->
<div id="cmt-<?= $q['id'] ?>" class="comment-container" style="display:none; margin-top: 20px;">
  <!-- comment list -->
  <?php
    $comments = getCommentsByQuestion($pdo, $q['id']);
    foreach ($comments as $cmt):
  ?>
    <div class="comment-box">
      <strong><?= htmlspecialchars($cmt['username']) ?>:</strong> <?= htmlspecialchars($cmt['text']) ?>
    </div>
  <?php endforeach; ?>

  <!-- comment form -->
  <form action="addcomment.php" method="post" style="margin-top: 10px;">
    <input type="hidden" name="question_id" value="<?= $q['id'] ?>">
    <input type="text" name="comment_text" placeholder="Write a comment..." required style="width: 80%; padding: 8px;">
    <input type="submit" value="Send" class="btn-edit">
  </form>
</div>
  </div>
<?php endforeach; ?>

<script>
  function toggleComment(id) {
    const section = document.getElementById(id);
    if (section.style.display === 'none' || section.style.display === '') {
      section.style.display = 'block';
    } else {
      section.style.display = 'none';
    }
  }
</script>

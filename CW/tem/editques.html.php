
<h2>Edit Question</h2>

<form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $questionData['id'] ?>">

  <label for="title">Title:</label>
  <input type="text" name="title" id="title" value="<?= $questionData['title'] ?>" required>

  <label for="text">Content:</label>
  <textarea name="text" id="text" rows="5" required><?= $questionData['text'] ?></textarea>

  <div style="display: flex; align-items: center; gap: 10px;">
    <label for="user" style="margin: 0;">Posted by:</label>
    <strong><span><?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?></span></strong>
  </div>
  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

  <label for="module">Module:</label>
  <select name="module_id" id="module" required>
    <?= $questionData['moduleOptions'] ?>
  </select>
  
  <?php if (!empty($questionData['image'])): ?>
    <p>Current Image: <?= $questionData['image'] ?></p>
    <img src="images/<?= $questionData['image'] ?>" width="100">
  <?php endif; ?>

  <label for="question_image">Upload Image:</label>
  <input type="file" name="question_image" id="question_image">

  <input type="submit" value="Save">
</form>
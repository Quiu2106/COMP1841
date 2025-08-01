<h2>Add New Question</h2>

<form action="" method="post"enctype="multipart/form-data">
  <label for="title">Title:</label>
  <input type="text" name="title" id="title">

  <label for="text">Content:</label>
  <textarea name="text" id="text" rows="5"></textarea>

  <div style="display: flex; align-items: center; gap: 10px;">
    <label for="user" style="margin: 0;">Posted by:</label>
    <strong><span><?= $userName ?></span></strong>
  </div>
  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">



  <label for="module">Module:</label>
  <select name="module_id" id="module">
    <?= $moduleOptions ?>
  </select>

  <label for="question_image">Upload Image:</label>
  <input type="file" name="question_image" id="question_image">


  <input type="submit" value="Add Question">
</form>

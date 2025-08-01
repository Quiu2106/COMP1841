
<div class="edit-comment-container">
  <h2>Edit Comment</h2>
  <form action="editcomment.php?id=<?= $comment['id'] ?>" method="post">
    <label for="comment_text">Edit your comment:</label>
    <input type="text" name="comment_text" id="comment_text" value="<?= htmlspecialchars($comment['text']) ?>" required>
    <input type="submit" value="Save">
  </form>
</div>

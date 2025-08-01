<h2>Edit Module</h2>
<form method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($m['id']) ?>">
    <label for="name">Module Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($m['name']) ?>" required>
    <input type="submit" value="Update Module">
</form>

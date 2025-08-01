<h2>Edit User</h2>

<form action="" method="post">
  <input type="hidden" name="id" value="<?= $userData['id'] ?>">

  <label for="name">Name:</label>
  <input type="text" name="name" id="name" value="<?= $userData['name'] ?>">

  <label for="email">Email:</label>
  <input type="email" name="email" id="email" value="<?= $userData['email'] ?>">

  <input type="submit" value="Save">
</form>

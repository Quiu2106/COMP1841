<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href ="css/final-cw.css">
    <title>Student Q&A Forum</title>
</head>
<body>
    <header><h1>Coursework 1841</h1></header>
<nav class="main-nav">
  <ul class="nav-left">
    <li><a href="index.php">Home</a></li>
    <li><a href="ques.php">List of Questions</a></li>
    <li><a href="addques.php">Add a new questions</a></li>
    <li><a href="module.php">Modules</a></li>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <li><a href="user.php">Users</a></li>
      <li><a href="adduser.php">Add a new user</a></li>
      <li><a href="addmodule.php">Add a new module</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="admin_mess.php">Admin Messages</a></li>
    <?php else: ?>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="contact.php">Contact Us</a></li>
      <li><a href="user_replies.php">Replies</a></li>
    <?php endif; ?>
  </ul>
    <div class="search-container">
  <button class="search-icon" onclick="toggleSearch()">🔍</button>
  <input type="text" id="searchInput" class="hidden" placeholder="Search..." onkeyup="smartFilter()">
</div>
  <script src="search.js.php"></script>
<?php if (isset($_SESSION['user_id'])): ?>
  <div class="nav-right">
    <span class="logged-user">
      👤 <?= htmlspecialchars($_SESSION['name']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)
    </span>
    <form action="logout.php" method="post" style="display:inline;">
      <button type="submit" class="btn-login" style="margin-left:12px;">Logout</button>
    </form>
  </div>
<?php else: ?>
  <div class="nav-right">
    <a href="login.php" class="btn-login">Login</a>
    <a href="signup.php" class="btn-signup">Sign Up</a>
  </div>
<?php endif; ?>

</nav>

    <main>
        <?=$output?>
    </main>
    <footer>&copy; CourseWork 2025</footer>

</body>
</html>
<h2>Module List</h2>

<div class="module-grid">
  <?php foreach ($modules as $m): ?>
    <div class="module-box">
      <p class="module-name"><?= $m['name'] ?></p>
      <div class="module-actions-row">
        <?= $m['edit_link'] ?>
        <?= $m['delete_form'] ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>


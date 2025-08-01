
<h2>User Management</h2>

<?php if (isset($_SESSION['message'])): ?>
    <div style="background:#00AA00;color:#fff;padding:10px;border-radius:5px;margin-bottom:20px;">
        <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<table border="1" style="width:100%;border-collapse:collapse;margin-top:20px;">
    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:12px;text-align:left;">Name</th>
            <th style="padding:12px;text-align:left;">Email</th>
            <th style="padding:12px;text-align:center;">Role</th>
            <th style="padding:12px;text-align:center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td style="padding:10px;"><?= $user['name'] ?></td>
            <td style="padding:10px;"><?= $user['email'] ?></td>
            <td style="padding:10px;text-align:center;">
                <span style="background:<?= $user['role'] === 'admin' ? '#ff6b6b' : '#4ecdc4' ?>;color:#fff;padding:4px 8px;border-radius:4px;font-size:0.9em;">
                    <?= ucfirst($user['role']) ?>
                </span>
            </td>
            <td style="padding:10px;text-align:center;">
                <div style="display:flex;gap:8px;justify-content:center;align-items:center;">
                    <?= $user['role_form'] ?>
                    <?= $user['delete_form'] ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
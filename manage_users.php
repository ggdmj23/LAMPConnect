<?php
/**
 * manage_users.php
 * ----------------
 * Allows admins and super_admins to view registered users.
 * Only regular users can be deleted via modal confirmation.
 */

require_once 'includes/require_admin.php';
require_once 'includes/db.php';
require_once 'includes/auth_utils.php';

$pdo = getPDO();
$pageTitle = "User Management";
include 'includes/header.php';

// Fetch all users except the logged-in one
$stmt = $pdo->prepare("SELECT id, username, email, role FROM users WHERE id != ?");
$stmt->execute([getCurrentUserId()]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-layout">

  <!-- LEFT SIDEBAR -->
  <aside class="admin-sidebar">
    <h3><i class="fas fa-toolbox"></i> Admin Menu</h3>
    <ul class="admin-menu">
      <?php if (isSuperAdmin()): ?>
        <li><i class="fas fa-user-shield"></i> <a href="super_manage_users.php">Role Management</a></li>
      <?php endif; ?>

      <li><i class="fas fa-comments"></i> <a href="message_center.php">Message Center</a></li>
      <li><i class="fas fa-file-alt"></i> <a href="#">Reports</a></li>
      <li><i class="fas fa-cogs"></i> <a href="#">System Settings</a></li>

      <?php if (isAdmin()): ?>
        <li><i class="fas fa-tools"></i> <a href="admin-panel.php">Admin Panel</a></li>
      <?php endif; ?>

      <li><i class="fas fa-user-cog"></i> <a href="dashboard.php">Dashboard</a></li>
      <li>
        <i class="fas fa-sign-out-alt"></i>
        <a href="logout.php">Logout (<?= htmlspecialchars(getCurrentUser()['name']) ?>)</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <h2>User Management</h2>

    <table class="user-table">
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
              <?php if ($user['role'] === 'user'): ?>
                <button class="action-link delete-user-btn"
                        data-id="<?= htmlspecialchars($user['id']) ?>"
                        data-name="<?= htmlspecialchars($user['username']) ?>"
                        data-confirm="Are you sure you want to delete user '<?= htmlspecialchars($user['username']) ?>'?">
                  Delete
                </button>
              <?php else: ?>
                <em>Protected</em>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- RIGHT SIDEBAR -->
  <aside class="admin-spacer">
    <h3><i class="fas fa-info-circle"></i> Info</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-trash-alt"></i> You may delete regular users</li>
      <li><i class="fas fa-lock"></i> Admin/Super Admin accounts are protected</li>
    </ul>
  </aside>
</div>

<!-- Delete Confirmation Modal -->
<div id="confirmation-modal" class="modal hidden">
  <div class="modal-content">
    <p id="modal-message">Are you sure?</p>
    <div class="modal-actions">
      <form method="POST" id="confirm-form" action="actions/delete_user.php">
        <input type="hidden" name="message_id" id="modal-message-id">
        <input type="hidden" name="user_id" id="modal-user-id">
        <button type="submit" id="confirm-btn" class="confirm">[ YES ]</button>
        <button type="button" id="cancel-btn" class="cancel">[ CANCEL ]</button>
      </form>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/modals.js" defer></script>

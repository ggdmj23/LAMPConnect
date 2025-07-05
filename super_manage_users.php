<?php

/**
 * super_manage_users.php
 * -----------------------
 * Super Admin-only page for managing user roles.
 * Lists all users except the currently logged-in Super Admin,
 * allowing promotion/demotion between user and admin roles.
 */

require_once 'includes/require_super_admin.php'; // Enforce Super Admin access
require_once 'includes/db.php';

$pdo = getPDO();
$pageTitle = "Super Admin - User Control";
include 'includes/header.php';

// Fetch all users except the logged-in super admin
$stmt = $pdo->prepare("SELECT id, username, email, role FROM users WHERE id != ?");
$stmt->execute([$_SESSION['user']['id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-layout">

  <!-- LEFT SIDEBAR -->
  <aside class="admin-sidebar">
    <h3><i class="fas fa-toolbox"></i> Admin Menu</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-comments"></i> <a href="#">Message Center</a></li>
      <li><i class="fas fa-file-alt"></i> <a href="#">Reports</a></li>
      <li><i class="fas fa-cogs"></i> <a href="#">System Settings</a></li>

      <li><i class="fas fa-users-cog"></i> <a href="manage_users.php">User Management</a></li>
      <li><i class="fas fa-tools"></i> <a href="admin-panel.php">Admin Panel</a></li>
      <li><i class="fas fa-user-cog"></i> <a href="dashboard.php">Dashboard</a></li>
      <li>
        <i class="fas fa-sign-out-alt"></i>
        <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user']['name']) ?>)</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <h2>Super Admin: User Management</h2>

    <table class="user-table">
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
      </tr>

      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['username']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['role']) ?></td>
          <td>
            <?php if ($user['role'] === 'user'): ?>
              <a href="actions/promote.php?id=<?= $user['id'] ?>"
                class="action-link"
                data-action="promote"
                data-username="<?= htmlspecialchars($user['username']) ?>">
                Promote to Admin
              </a>
            <?php elseif ($user['role'] === 'admin'): ?>
              <a href="actions/demote.php?id=<?= $user['id'] ?>"
                class="action-link"
                data-action="demote"
                data-username="<?= htmlspecialchars($user['username']) ?>">
                Demote to User
              </a>
            <?php else: ?>
              <em>Super Admin</em>
            <?php endif; ?>

          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- RIGHT SIDEBAR -->
  <aside class="admin-spacer">
    <h3><i class="fas fa-info-circle"></i> Controls</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-arrow-up"></i> Promote users to Admin</li>
      <li><i class="fas fa-arrow-down"></i> Demote Admins to User</li>
      <li><i class="fas fa-lock"></i> Super Admin accounts are locked</li>
    </ul>
  </aside>

</div>

<!-- Confirmation Modal -->
<div id="confirmation-modal" class="modal hidden">
  <div class="modal-content">
    <p id="modal-message">Are you sure?</p>
    <div class="modal-actions">
      <form method="POST" id="confirm-form" action="#">
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
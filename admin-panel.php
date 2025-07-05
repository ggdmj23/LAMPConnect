<?php

/**
 * admin-panel.php
 * ----------------
 * Displays the Admin Panel for users with 'admin' or 'super_admin' roles.
 * Provides access to user management, message center, and system tools.
 */

require_once 'includes/require_admin.php'; // Gatekeeper for admin/super_admin
$pageTitle = "Admin Panel";
include 'includes/header.php';
?>

<div class="admin-layout">

  <!-- LEFT SIDEBAR -->
  <aside class="admin-sidebar">
    <h3><i class="fas fa-toolbox"></i> Admin Menu</h3>
    <ul class="admin-menu">

      <!-- Admins and Super Admins -->
      <?php if (in_array($_SESSION['user']['role'], ['admin', 'super_admin'])): ?>
        <li><i class="fas fa-users-cog"></i> <a href="manage_users.php">User Management</a></li>
      <?php endif; ?>

      <!-- Super Admin Only -->
      <?php if ($_SESSION['user']['role'] === 'super_admin'): ?>
        <li><i class="fas fa-user-shield"></i> <a href="super_manage_users.php">Role Management</a></li>
      <?php endif; ?>

      <li><i class="fas fa-comments"></i> <a href="message_center.php">Message Center</a></li>
      <li><i class="fas fa-file-alt"></i> <a href="#">Reports</a></li>
      <li><i class="fas fa-cogs"></i> <a href="#">System Settings</a></li>
      <li><i class="fas fa-user-cog"></i> <a href="dashboard.php">Dashboard</a></li>
      <li>
        <i class="fas fa-sign-out-alt"></i>
        <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user']['name']) ?>)</a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <h2>Admin Panel</h2>

    <div class="console-box">
      <p><span class="console-label ok">[ACCESS GRANTED]</span> Welcome <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></p>
      <p><span class="console-label ok">[ROLE]</span> <?= htmlspecialchars($_SESSION['user']['role']) ?></p>
    </div>

    <p>Select a module from the left to get started.</p>
  </div>

  <!-- RIGHT SIDEBAR -->
  <aside class="admin-spacer">
    <h3><i class="fas fa-info-circle"></i> Quick Tips</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-user-check"></i> Manage user accounts securely</li>
      <li><i class="fas fa-chart-line"></i> Review reports</li>
      <li><i class="fas fa-shield-alt"></i> Super Admins can change roles</li>
    </ul>
  </aside>

</div>

<?php include 'includes/footer.php'; ?>
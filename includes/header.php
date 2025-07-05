<?php

/**
 * header.php
 * ----------
 * Shared layout fragment that renders the <head> section and the navigation header.
 * Dynamically shows nav links and highlights the current page.
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

require_once __DIR__ . '/auth_utils.php';
$currentUser = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= isset($pageTitle) ? $pageTitle . ' | ' : '' ?>LAMPConnect</title>
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="js/navbar-scroll.js" defer></script>
</head>

<body>
  <header>
    <h1 data-text="LAMP Connect" class="glitch-title">LAMP Connect</h1>

    <nav class="nav">
      <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a>
      <a href="about.php" class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">About</a>
      <a href="contact.php" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">Contact</a>

      <?php if ($currentUser): ?>
        <a href="dashboard.php" class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
          <i class="fas fa-user-cog"></i> Dashboard
        </a>

        <?php if (hasAnyRole(['admin', 'super_admin'])): ?>
          <a href="admin-panel.php" class="<?= $currentPage === 'admin-panel.php' ? 'active' : '' ?>">
            <i class="fas fa-tools"></i> Admin Panel
          </a>
          <a href="manage_users.php" class="<?= $currentPage === 'manage_users.php' ? 'active' : '' ?>">
            <i class="fas fa-users-cog"></i> Manage Users
          </a>
        <?php endif; ?>

        <?php if (hasRole('super_admin')): ?>
          <a href="super_manage_users.php" class="<?= $currentPage === 'super_manage_users.php' ? 'active' : '' ?>">
            <i class="fas fa-user-shield"></i> Role Management
          </a>
        <?php endif; ?>

        <div class="nav-dropdown">
          <a href="#" class="nav-dropdown-toggle">
            <i class="fas fa-user-circle"></i> <?= htmlspecialchars($currentUser['name']) ?> ▾
          </a>
          <div class="nav-dropdown-menu">
            <a href="edit_profile.php" class="<?= $currentPage === 'edit_profile.php' ? 'active' : '' ?>">Edit Profile</a>
            <a href="logout.php" class="<?= $currentPage === 'logout.php' ? 'active' : '' ?>">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </div>
      <?php else: ?>
        <a href="register.php" class="<?= $currentPage === 'register.php' ? 'active' : '' ?>">
          <i class="fas fa-user-plus"></i> Register
        </a>
        <a href="login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">
          <i class="fas fa-sign-in-alt"></i> Login
        </a>
      <?php endif; ?>
    </nav>
  </header>
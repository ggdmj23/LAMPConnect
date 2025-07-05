<?php

/**
 * index.php
 * ---------
 * Home page of the LAMPConnect project.
 * - Displays welcome messages
 * - Handles session-based status display
 * - Introduces the project
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$pageTitle = "Home";
include 'includes/header.php';
?>

<div class="admin-layout">

  <!-- LEFT SIDEBAR: Quick Access Links -->
  <aside class="admin-sidebar">
    <h3><i class="fas fa-user-circle"></i> Quick Access</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-user-cog"></i> <a href="dashboard.php">Dashboard</a></li>
      <li><i class="fas fa-edit"></i> <a href="edit_profile.php">Edit Profile</a></li>
      <li><i class="fas fa-lock"></i> <a href="change_password.php">Change Password</a></li>

      <?php if (isset($_SESSION['user'])): ?>
        <li>
          <i class="fas fa-sign-out-alt"></i>
          <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?>)</a>
        </li>
      <?php else: ?>
        <li>
          <i class="fas fa-sign-in-alt"></i>
          <a href="login.php">Login</a>
        </li>
      <?php endif; ?>
    </ul>
  </aside>

  <!-- MAIN CONTENT AREA -->
  <div class="main-content">

    <!-- Greeting after login (if session username is set) -->
    <?php if (isset($_SESSION['username'])): ?>
      <div class="status-message success">
        <span class="console-label ok">[OK]</span>
        Hello <?= htmlspecialchars($_SESSION['username']) ?>, welcome back!
      </div>
    <?php endif; ?>

    <!-- Feedback message for successful logout -->
    <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
      <div class="status-message">
        <span class="console-label ok">[OK]</span>
        You have been logged out.
      </div>
    <?php endif; ?>

    <!-- Welcome Introduction -->
    <h2>Welcome to LAMPConnect</h2>
    <p>
      <strong>LAMPConnect</strong> is your lightweight, modular web starter built with
      Linux, Apache, MySQL, and PHP. Perfect for learning full-stack basics using real-world components
      like forms, sessions, databases, and email.
    </p>

    <!-- System Console Box -->
    <div class="console-box">
      <p>System status: <strong>[<span class="status-ok">OK</span>]</strong></p>
      <p>Welcome to <strong>LAMPConnect</strong>. Awaiting commands.</p>
    </div>

    <!-- Getting Started Section -->
    <h3>Get Started</h3>
    <ul class="custom-bullets">
      <li><a href="about.php">Learn more about the project</a></li>
      <li><a href="contact.php">Send us a message</a></li>
    </ul>
  </div>

  <!-- RIGHT SIDEBAR: Info + News -->
  <aside class="admin-spacer">
    <h3><i class="fas fa-info-circle"></i> System Info</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-server"></i> Server: <span style="color:#0f0;">Apache 2.4</span></li>
      <li><i class="fas fa-database"></i> Database: <span style="color:#0f0;">MySQL 8.0</span></li>
      <li><i class="fas fa-code"></i> PHP: <span style="color:#0f0;"><?= htmlspecialchars(phpversion()) ?></span></li>
      <li><i class="fas fa-clock"></i> Uptime: <span style="color:#0f0;">Online</span></li>
    </ul>

    <h3><i class="fas fa-bullhorn"></i> News</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-star"></i> New feature: Edit Profile added!</li>
      <li><i class="fas fa-envelope"></i> Contact form now supports email</li>
      <li><i class="fas fa-shield-alt"></i> Admin role restrictions active</li>
    </ul>
  </aside>
</div>

<?php include 'includes/footer.php'; ?>
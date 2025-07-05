<?php

/**
 * dashboard.php
 * -------------
 * Displays the authenticated user's dashboard:
 * - Shows user info, submitted messages, and message actions
 * - Allows filtering by favorites
 * - Provides access to account settings
 */

require_once 'includes/require_auth.php'; // session already started here
require_once 'includes/db.php';

$pageTitle = "Dashboard";
include 'includes/header.php';

// Escape shortcut
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// === Setup ===
$pdo = getPDO();
$userId = $_SESSION['user']['id'];
$dbError = false;

// === Handle Message Filter ===
if (isset($_GET['filter'])) {
  $_SESSION['dashboard_filter'] = $_GET['filter'];
}
$filter = $_SESSION['dashboard_filter'] ?? 'all';

// === Fetch User Messages ===
try {
  $sql = "SELECT id, name, email, message, submitted_at, is_favorite FROM messages WHERE user_id = :user_id";
  if ($filter === 'favorites') {
    $sql .= " AND is_favorite = 1";
  }
  $sql .= " ORDER BY submitted_at DESC";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(['user_id' => $userId]);
  $userMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log("DB error on dashboard.php: " . $e->getMessage());
  $userMessages = [];
  $dbError = true;
}
?>

<div class="admin-layout">

  <!-- LEFT SIDEBAR -->
  <aside class="admin-sidebar">
    <h3><i class="fas fa-user-cog"></i> Your Tools</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-user-edit"></i> <a href="edit_profile.php">Edit Profile</a></li>
      <li><i class="fas fa-key"></i> <a href="change_password.php">Change Password</a></li>
      <li><i class="fas fa-paper-plane"></i> <a href="contact.php">Send New Message</a></li>
      <li><i class="fas fa-history"></i> <a href="#your-messages">View Message History</a></li>

      <?php if (in_array($_SESSION['user']['role'], ['admin', 'super_admin'])): ?>
        <li><i class="fas fa-tools"></i> <a href="admin-panel.php">Admin Panel</a></li>
        <li><i class="fas fa-users-cog"></i> <a href="manage_users.php">User Management</a></li>
      <?php endif; ?>

      <?php if ($_SESSION['user']['role'] === 'super_admin'): ?>
        <li><i class="fas fa-user-shield"></i> <a href="super_manage_users.php">Role Management</a></li>
      <?php endif; ?>

      <li><i class="fas fa-sign-out-alt"></i> <a href="logout.php">Logout (<?= h($_SESSION['user']['name']) ?>)</a></li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <h2>Welcome to your Dashboard</h2>

    <div class="console-box">
      <p><span class="console-label ok">[SESSION]</span> Logged in as <strong><?= h($_SESSION['user']['name']) ?></strong></p>
      <p><span class="console-label ok">[ROLE]</span> You are a <strong><?= h($_SESSION['user']['role']) ?></strong></p>
    </div>

    <!-- ACCOUNT SETTINGS -->
    <section class="dashboard-section">
      <h3>Account Settings</h3>
      <ul class="custom-bullets">
        <li><a href="edit_profile.php" class="console-link">Edit your username, email, or password</a></li>
      </ul>
    </section>

    <!-- USER MESSAGES -->
    <section class="dashboard-section" id="your-messages">
      <h3>Your Messages</h3>
      <p class="info-note"><em>Only messages submitted while logged in will appear here.</em></p>

      <a href="?filter=favorites" class="console-link">Show Favorites Only</a> |
      <a href="?filter=all" class="console-link">Show All</a>

      <?php if ($dbError): ?>
        <div class="status-message error">⚠️ Could not load your messages. Please try again later.</div>
      <?php endif; ?>

      <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
        <div class="status-message success">Message deleted successfully.</div>
      <?php endif; ?>

      <?php if (empty($userMessages)): ?>
        <p><em>You haven’t submitted any messages yet.</em></p>
      <?php else: ?>
        <ul class="message-list">
          <?php foreach ($userMessages as $msg): ?>
            <li class="message-item <?= $msg['is_favorite'] ? 'favorite' : '' ?>">
              <p><strong>Message ID:</strong> <?= h($msg['id']) ?></p>
              <p><strong>Sent on:</strong> <?= h($msg['submitted_at']) ?></p>
              <p><strong>Name:</strong> <?= h($msg['name']) ?></p>
              <p><strong>Email:</strong> <?= h($msg['email']) ?></p>
              <p><strong>Message Preview:</strong><br>
                <?= nl2br(h(mb_strimwidth($msg['message'], 0, 100, '...'))) ?>
              </p>

              <button class="read-more-btn"
                data-id="<?= h($msg['id']) ?>"
                data-name="<?= h($msg['name']) ?>"
                data-email="<?= h($msg['email']) ?>"
                data-date="<?= h($msg['submitted_at']) ?>"
                data-message="<?= h($msg['message']) ?>"
                data-favorite="<?= $msg['is_favorite'] ? '1' : '0' ?>">
                🔎 Read More
              </button>

              <div class="message-actions">
                <form method="POST" action="actions/toggle_favorite.php" class="inline-form">
                  <input type="hidden" name="message_id" value="<?= h($msg['id']) ?>">
                  <button type="submit" class="fav-toggle-btn">
                    <?= $msg['is_favorite'] ? '⭐ Unfavorite' : '☆ Favorite' ?>
                  </button>
                </form>

                <button class="action-link delete-msg-btn delete-button"
                  data-id="<?= h($msg['id']) ?>"
                  data-confirm="Are you sure you want to delete this message?">
                  Delete
                </button>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </section>

    <!-- Message Preview Modal -->
    <div id="preview-modal" class="modal hidden">
      <div class="modal-content user-style">
        <h3 class="modal-title">
          <span class="typewriter-text">User Message Details</span><span class="cursor">_</span>
        </h3>
        <div id="favorite-indicator" class="favorite-star">☆</div>

        <div class="typewriter-block modal-scrollable">
          <p><strong>ID:</strong> <span id="preview-id"></span></p>
          <p><strong>Name:</strong> <span id="preview-name"></span></p>
          <p><strong>Email:</strong> <span id="preview-email"></span></p>
          <p><strong>Date:</strong> <span id="preview-date"></span></p>
          <p><strong>Message:</strong><br>
          <div id="preview-message"></div>
          </p>
        </div>

        <div class="modal-actions">
          <button id="close-preview">Close</button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal hidden">
      <div class="modal-content">
        <p id="modal-message">Are you sure?</p>
        <div class="modal-actions">
          <form method="POST" id="confirm-form" action="actions/delete_message.php">
            <input type="hidden" name="message_id" id="modal-message-id">
            <input type="hidden" name="user_id" id="modal-user-id">
            <button type="submit" id="confirm-btn" class="confirm">[ YES ]</button>
            <button type="button" id="cancel-btn" class="cancel">[ CANCEL ]</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Support Section -->
    <section class="dashboard-section">
      <h3>Need Help?</h3>
      <p>If you have any questions or issues, please <a href="contact.php">contact support</a>.</p>
    </section>
  </div>

  <!-- RIGHT SIDEBAR -->
  <aside class="admin-spacer">
    <h3><i class="fas fa-id-badge"></i> Account Info</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-user"></i> Name: <strong><?= h($_SESSION['user']['name']) ?></strong></li>
      <li><i class="fas fa-envelope"></i> Email: <strong><?= h($_SESSION['user']['email']) ?></strong></li>
      <li><i class="fas fa-user-tag"></i> Role: <strong><?= h($_SESSION['user']['role']) ?></strong></li>
    </ul>

    <h3><i class="fas fa-lightbulb"></i> Tips</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-trash-alt"></i> You can delete messages anytime</li>
      <li><i class="fas fa-edit"></i> Keep your info up to date</li>
      <li><i class="fas fa-bell"></i> Watch this space for updates</li>
    </ul>
  </aside>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/modals.js" defer></script>
<script src="js/message-preview.js" defer></script>
<script src="js/scroll-preserve.js" defer></script>
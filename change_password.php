<?php

/**
 * change_password.php
 * -------------------
 * Allows authenticated users to change their password.
 * Displays appropriate success and error messages.
 */

require_once 'includes/require_auth.php';
require_once 'includes/db.php';

$pageTitle = "Change Password";
include 'includes/header.php';

$pdo = getPDO();
$userId = $_SESSION['user']['id'];

// Fetch user info for sidebar display
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="admin-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="admin-sidebar">
        <h3><i class="fas fa-user-cog"></i> Account Tools</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-user-cog"></i> <a href="dashboard.php">Dashboard</a></li>
            <li><i class="fas fa-edit"></i> <a href="edit_profile.php">Edit Profile</a></li>
            <li><i class="fas fa-envelope"></i> <a href="contact.php">Ask a Question</a></li>
            <li><i class="fas fa-paper-plane"></i> <a href="contact.php">Submit Feedback</a></li>
            <li>
                <i class="fas fa-sign-out-alt"></i>
                <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user']['name']) ?>)</a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                <div class="status-message success">Password changed successfully.</div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <?php if ($_GET['reason'] === 'mismatch'): ?>
                    <div class="status-message error">New passwords do not match.</div>
                <?php elseif ($_GET['reason'] === 'wrongpass'): ?>
                    <div class="status-message error">Incorrect current password.</div>
                <?php elseif ($_GET['reason'] === 'weak'): ?>
                    <div class="status-message error">New password must be at least 8 characters long.</div>
                <?php elseif ($_GET['reason'] === 'empty'): ?>
                    <div class="status-message error">All fields are required.</div>
                <?php else: ?>
                    <div class="status-message error">Unknown error occurred.</div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <h2>Change Your Password</h2>

        <form action="actions/change_password_handler.php" method="POST">

            <!-- Current password field -->
            <label for="current_password">Current Password:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" id="current_password" name="current_password" required>
                <button type="button" class="toggle-password" aria-label="Show current password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <br><br>

            <!-- New password field -->
            <label for="new_password">New Password:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" id="new_password" name="new_password" required>
                <button type="button" class="toggle-password" aria-label="Show new password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <br><br>

            <!-- Confirm password field -->
            <label for="confirm_password">Confirm New Password:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" id="confirm_password" name="confirm_password" required>
                <button type="button" class="toggle-password" aria-label="Show confirm password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <br><br>

            <input type="submit" value="Change Password">
        </form>
    </div>

    <!-- RIGHT SIDEBAR -->
    <aside class="admin-spacer">
        <h3><i class="fas fa-shield-alt"></i> Security Tips</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-lock"></i> Use a strong, unique password</li>
            <li><i class="fas fa-check"></i> Confirm your password before saving</li>
            <li><i class="fas fa-sync"></i> Update your info regularly</li>
            <li><i class="fas fa-eye-slash"></i> Hide your password in public places</li>
        </ul>

        <h3><i class="fas fa-user-circle"></i> Profile Info</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-user"></i> Username: <strong><?= htmlspecialchars($user['username']) ?></strong></li>
            <li><i class="fas fa-envelope"></i> Email: <strong><?= htmlspecialchars($user['email']) ?></strong></li>
            <li><i class="fas fa-user-tag"></i> Role: <strong><?= htmlspecialchars($_SESSION['user']['role']) ?></strong></li>
        </ul>
    </aside>
</div>

<?php include 'includes/footer.php'; ?>

<!-- JS for show/hide password buttons -->
<script src="js/toggle-password.js"></script>
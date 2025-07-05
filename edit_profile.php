<?php

/**
 * edit_profile.php
 * ----------------
 * Allows authenticated users to update their username and email.
 * Requires password confirmation.
 */

require_once 'includes/require_auth.php';
require_once 'includes/db.php';

$pageTitle = "Edit Profile";
include 'includes/header.php';

$pdo = getPDO();
$userId = $_SESSION['user']['id'];

// Fetch current user information securely
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
            <li><i class="fas fa-key"></i> <a href="change_password.php">Change Password</a></li>
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
                <div class="status-message success">Profile updated successfully.</div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <?php if (isset($_GET['reason'])): ?>
                    <?php if ($_GET['reason'] === 'server'): ?>
                        <div class="status-message error">⚠️ Server error. Please try again later.</div>
                    <?php elseif ($_GET['reason'] === 'empty'): ?>
                        <div class="status-message error">⚠️ Username, email, and password are required.</div>
                    <?php elseif ($_GET['reason'] === 'wrongpass'): ?>
                        <div class="status-message error">Incorrect current password. Changes not saved.</div>
                    <?php else: ?>
                        <div class="status-message error">⚠️ Unknown error occurred.</div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <h2>Edit Your Profile</h2>

        <!-- Profile Update Form -->
        <form action="actions/update_profile.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required
                value="<?= htmlspecialchars($user['username']) ?>"><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required
                value="<?= htmlspecialchars($user['email']) ?>"><br><br>

            <label for="current_password">Confirm Password to Save Changes:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" id="current_password" name="current_password" required>
                <button type="button" class="toggle-password" aria-label="Show password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <br><br>

            <input type="submit" value="Update">
        </form>

        <p class="glitch-text">
            <a href="change_password.php">Want to change your password?</a>
        </p>
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

<!-- Password visibility toggle -->
<script src="js/toggle-password.js"></script>
<?php

/**
 * login.php
 * ---------
 * Displays the login form for existing users.
 * Shows feedback based on status query parameters passed via URL.
 */

$pageTitle = "Login";
include 'includes/header.php';

// Initialize message display
$message = '';
$class = '';

// Display messages based on URL parameters
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = '<span class="console-label ok">[OK]</span> You have successfully registered. Please log in.';
        $class = 'success';
    } elseif ($_GET['status'] === 'error') {
        if ($_GET['reason'] === 'invalid') {
            $message = '<span class="console-label error">[ERROR]</span> Invalid username/email or password.';
        } elseif ($_GET['reason'] === 'empty') {
            $message = '<span class="console-label warn">[WARN]</span> Please fill in both fields.';
        } else {
            $message = '<span class="console-label error">[ERROR]</span> Login failed. Try again.';
        }
        $class = 'error';
    }
}
?>

<div class="admin-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="admin-sidebar">
        <h3><i class="fas fa-sign-in-alt"></i> Welcome Back</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-user-plus"></i> <a href="register.php">Create an Account</a></li>
            <li><i class="fas fa-key"></i> <a href="#">Forgot Password?</a></li>
            <li><i class="fas fa-question-circle"></i> <a href="about.php">About LAMPConnect</a></li>
            <li><i class="fas fa-envelope"></i> <a href="contact.php">Need Help?</a></li>
            <li><i class="fas fa-shield-alt"></i> <a href="#">Security Tips</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <?php if ($message): ?>
            <!-- Display status message -->
            <div class="status-message <?= htmlspecialchars($class, ENT_QUOTES, 'UTF-8') ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <h2>Login</h2>

        <form action="actions/login_handler.php" method="POST" autocomplete="off">
            <label for="identifier">Username or Email:</label><br>
            <input type="text" name="identifier" id="identifier" required><br><br>

            <label for="password">Password:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" id="password" name="password" required>
                <button type="button" class="toggle-password" aria-label="Show password">
                    <i class="fas fa-eye"></i>
                </button>
            </div><br><br>

            <button type="submit">Login</button>
        </form>
    </div>

    <!-- RIGHT SIDEBAR -->
    <aside class="admin-spacer">
        <h3><i class="fas fa-lightbulb"></i> Tips for Logging In</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-id-badge"></i> You can use your username <em>or</em> email</li>
            <li><i class="fas fa-eye-slash"></i> Use the eye icon to preview password</li>
            <li><i class="fas fa-exclamation-triangle"></i> Too many failed attempts may lock your account</li>
            <li><i class="fas fa-user-check"></i> Not registered? <a href="register.php">Sign up here</a></li>
            <li><i class="fas fa-lock"></i> Never share your login credentials</li>
        </ul>
    </aside>

</div>

<?php include 'includes/footer.php'; ?>

<!-- ✅ Show/Hide password JS -->
<script src="js/toggle-password.js"></script>
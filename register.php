<?php

/**
 * register.php
 * ------------
 * Registration page:
 * - Displays feedback messages based on registration status
 * - Collects username, email, and password from the user
 */

$pageTitle = "Register";
include 'includes/header.php';

// === Handle Feedback Messages ===
$message = '';
$class = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = '<span class="console-label ok">[OK]</span> Registration successful. You can now log in.';
        $class = 'success';
    } elseif ($_GET['status'] === 'error') {
        if ($_GET['reason'] === 'exists') {
            $message = '<span class="console-label error">[ERROR]</span> Username or email already in use.';
        } elseif ($_GET['reason'] === 'empty') {
            $message = '<span class="console-label warn">[WARN]</span> Please fill in all required fields.';
        } elseif ($_GET['reason'] === 'nomatch') {
            $message = '<span class="console-label warn">[WARN]</span> Passwords do not match.';
        } else {
            $message = '<span class="console-label error">[ERROR]</span> Something went wrong. Please try again.';
        }
        $class = 'error';
    }
}
?>

<div class="admin-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="admin-sidebar">
        <h3><i class="fas fa-user-plus"></i> New to LAMPConnect?</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-info-circle"></i> <a href="about.php">What is LAMPConnect?</a></li>
            <li><i class="fas fa-book"></i> <a href="#">How It Works</a></li>
            <li><i class="fas fa-envelope"></i> <a href="contact.php">Need Help?</a></li>
            <li><i class="fas fa-lock"></i> <a href="#">Security & Privacy</a></li>
            <li><i class="fas fa-sign-in-alt"></i> <a href="login.php">Already Registered?</a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- Feedback Message -->
        <?php if ($message): ?>
            <div class="status-message <?= htmlspecialchars($class, ENT_QUOTES, 'UTF-8') ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <h2>Register</h2>

        <!-- Registration Form -->
        <form action="actions/register_handler.php" method="POST" autocomplete="off">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="password">Password:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" name="password" id="password" required> <!-- minlength="8" -->
                <button type="button" class="toggle-password" aria-label="Show password">
                    <i class="fas fa-eye"></i>
                </button>
            </div><br><br>

            <label for="confirm_password">Confirm Password:</label><br>
            <div class="password-inline-wrapper">
                <input type="password" name="confirm_password" id="confirm_password" required> <!-- minlength="8" -->
                <button type="button" class="toggle-password" aria-label="Show confirm password">
                    <i class="fas fa-eye"></i>
                </button>
            </div><br><br>

            <button type="submit">Register</button>
        </form>
    </div>

    <!-- RIGHT SIDEBAR -->
    <aside class="admin-spacer">
        <h3><i class="fas fa-lightbulb"></i> Tips for Success</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-user-check"></i> Choose a unique username</li>
            <li><i class="fas fa-envelope-open-text"></i> Use a valid email address</li>
            <li><i class="fas fa-key"></i> Password must be at least 8 characters</li>
            <li><i class="fas fa-shield-alt"></i> Never share your credentials</li>
            <li><i class="fas fa-eye-slash"></i> Use the eye icon to preview passwords</li>
        </ul>

        <h3><i class="fas fa-question-circle"></i> Trouble Registering?</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-bug"></i> <a href="contact.php">Report an Issue</a></li>
            <li><i class="fas fa-question"></i> <a href="faq.php">Visit FAQ (Coming Soon)</a></li>
        </ul>
    </aside>

</div>

<?php include 'includes/footer.php'; ?>

<!-- JS to toggle password visibility -->
<script src="js/toggle-password.js"></script>
<?php

/**
 * logout.php
 * ----------
 * Safely logs out the user:
 * - Logs the logout action
 * - Clears session data
 * - Destroys the session
 * - Deletes session cookie (if applicable)
 * - Redirects to homepage with logout status
 */

session_start();
require_once 'includes/logger.php';

// === Log user before clearing session ===
if (isset($_SESSION['user']['name'])) {
    $username = $_SESSION['user']['name'];
    app_log("User '$username' logged out", 'INFO');
} else {
    app_log("Unknown user session ended", 'WARN');
}

// === Clear all session variables ===
$_SESSION = [];

// === Destroy the session ===
session_destroy();

// === Optional: Remove session cookie (for completeness) ===
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// === Redirect to homepage with logout confirmation ===
header('Location: index.php?logout=success');
exit;

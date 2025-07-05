<?php

/**
 * process_contact.php
 * -------------------
 * Handles contact form submission:
 * - Sanitizes and validates input
 * - Saves message to database (logged or guest user)
 * - Sends notification email
 * - Redirects with status (success, partial, error)
 */

require_once 'includes/db.php';
require_once 'includes/auth_utils.php';
require_once 'includes/mail.php';
require_once 'includes/logger.php'; // ✅ Optional custom logging

// === DEV: Show errors (disable in production) ===
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// === Ensure session is active ===
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// === Step 1: Sanitize and Validate Input ===
$name    = sanitizeInput($_POST['name'] ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$message = trim($_POST['message'] ?? '');

// === Step 2: Save Message to Database ===
try {
    $pdo = getPDO();
    $userId = $_SESSION['user']['id'] ?? null;

    if ($userId !== null) {
        $stmt = $pdo->prepare("
            INSERT INTO messages (user_id, name, email, message)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $name, $email, $message]);
        app_log("Message stored for user ID $userId", 'INFO');
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO messages (name, email, message)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$name, $email, $message]);
        app_log("Message stored anonymously from $email", 'INFO');
    }
} catch (PDOException $e) {
    app_log("Database error while storing message: " . $e->getMessage(), 'ERROR');
    header("Location: contact.php?status=error");
    exit;
}

// === Step 3: Send Email Notification ===
$status = sendContactEmail($email, $name, $message);

if ($status) {
    app_log("Contact email sent successfully to admin from $email", 'INFO');
} else {
    app_log("Email failed to send from $email", 'WARN');
}

// === Step 4: Redirect with message preview ===
$previewStatus = ($userId !== null) ? 'user-preview' : 'guest-preview';

$redirectURL = 'contact.php?status=' . $previewStatus
    . '&name=' . urlencode($name)
    . '&email=' . urlencode($email)
    . '&message=' . urlencode($message)
    . '&mail=' . ($status ? 'success' : 'fail');

header("Location: $redirectURL");
exit;

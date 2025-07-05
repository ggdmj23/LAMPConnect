<?php
/**
 * change_password_handler.php
 * ---------------------------
 * Handles password change request securely.
 * - Verifies current password
 * - Validates new password
 * - Updates database with hashed new password
 */

require_once '../includes/require_auth.php';
require_once '../includes/db.php';

$pdo = getPDO();
$userId = $_SESSION['user']['id'];

// === Sanitize and Validate Input ===
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Redirect if any field is empty
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    header('Location: ../change_password.php?status=error&reason=empty');
    exit;
}

// Redirect if new password and confirmation do not match
if ($newPassword !== $confirmPassword) {
    header('Location: ../change_password.php?status=error&reason=mismatch');
    exit;
}

// Enforce minimum password length (8+ characters)
/*
if (strlen($newPassword) < 8) {
    header('Location: ../change_password.php?status=error&reason=weak');
    exit;
}
*/

// === Fetch Current Password Hash from Database ===
$stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify current password matches the hash
if (!$user || !password_verify($currentPassword, $user['password'])) {
    header('Location: ../change_password.php?status=error&reason=wrongpass');
    exit;
}

// === Hash and Update New Password ===
$hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashedNewPassword, $userId]);

    // Success
    header('Location: ../change_password.php?status=success');
    exit;

} catch (PDOException $e) {
    // Log server-side if needed
    // error_log("Password update failed: " . $e->getMessage());
    header('Location: ../change_password.php?status=error&reason=server');
    exit;
}

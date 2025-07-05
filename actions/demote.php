<?php

/**
 * demote.php
 * ----------
 * Demotes an 'admin' user to 'user' role.
 * Only accessible by Super Admins.
 */

require_once '../includes/require_super_admin.php';
require_once '../includes/db.php';

$pdo = getPDO();

// Sanitize and validate ID
$userId = $_GET['id'] ?? null;
$userId = is_numeric($userId) ? (int)$userId : null;

// Prevent self-demotion and invalid IDs
if (!$userId || $userId === $_SESSION['user']['id']) {
    header("Location: ../manage_users.php?status=error&reason=self_demote");
    exit;
}

try {
    // Fetch the target user
    $stmt = $pdo->prepare("SELECT username, role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../manage_users.php?status=error&reason=not_found");
        exit;
    }

    // Only demote if role is exactly 'admin'
    if ($user['role'] !== 'admin') {
        header("Location: ../manage_users.php?status=error&reason=not_admin");
        exit;
    }

    // Demote user to 'user'
    $updateStmt = $pdo->prepare("UPDATE users SET role = 'user' WHERE id = ?");
    $updateStmt->execute([$userId]);

    // Redirect with success
    $encodedName = urlencode($user['username']);
    header("Location: ../manage_users.php?status=success&action=demoted&user={$encodedName}");
    exit;
} catch (PDOException $e) {
    // Optional: log exception to file or monitoring system
    // error_log("Demotion error: " . $e->getMessage());

    header("Location: ../manage_users.php?status=error&reason=server");
    exit;
}

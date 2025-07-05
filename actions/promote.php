<?php

/**
 * promote.php
 * -----------
 * Promotes a user to 'admin' role.
 * Accessible only by users with 'super_admin' role.
 * Expects a valid numeric `id` via GET.
 */

require_once '../includes/require_super_admin.php';
require_once '../includes/db.php';

// Validate and sanitize GET input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../manage_users.php?status=error&reason=invalid_id');
    exit;
}

$userId = (int) $_GET['id'];
$pdo = getPDO();

try {
    // Check that the user exists and is currently a 'user'
    $stmt = $pdo->prepare("SELECT username, role FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: ../manage_users.php?status=error&reason=not_found');
        exit;
    }

    if ($user['role'] !== 'user') {
        header('Location: ../manage_users.php?status=error&reason=not_user');
        exit;
    }

    // Promote user to 'admin'
    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
    $stmt->execute([$userId]);

    // Redirect with success feedback
    $username = $user['username'];
    header('Location: ../manage_users.php?status=success&action=promoted&user=' . urlencode($username));
    exit;
} catch (PDOException $e) {
    // Optional: log error to a secure log file
    // error_log("Promotion error: " . $e->getMessage());

    header('Location: ../manage_users.php?status=error&reason=server');
    exit;
}

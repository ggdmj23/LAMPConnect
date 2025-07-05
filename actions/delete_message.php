<?php

/**
 * delete_message.php
 * ------------------
 * Securely deletes a message submitted by the currently logged-in user.
 * - Only handles POST requests
 * - Verifies message ownership before deletion
 * - Redirects back to dashboard with status
 */

require_once '../includes/require_auth.php';
require_once '../includes/db.php';

// ✅ Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../dashboard.php?status=error&reason=invalid_request');
    exit;
}

$pdo = getPDO();
$userId = $_SESSION['user']['id'] ?? null;
$messageId = $_POST['message_id'] ?? null;

// ✅ Validate input
if (!$messageId || !is_numeric($messageId) || !$userId) {
    header('Location: ../dashboard.php?status=error&reason=invalid_id');
    exit;
}

// ✅ Ensure the message belongs to the current user before deleting
try {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        'id' => $messageId,
        'user_id' => $userId
    ]);
} catch (PDOException $e) {
    error_log("❌ Message delete error: " . $e->getMessage());
    header('Location: ../dashboard.php?status=error&reason=db_error');
    exit;
}

// ✅ Redirect to dashboard with success status
header('Location: ../dashboard.php?status=deleted');
exit;

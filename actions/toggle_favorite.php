<?php

/**
 * toggle_favorite.php
 * -------------------
 * Toggles the 'is_favorite' flag for a message belonging to the logged-in user.
 * - Verifies ownership
 * - Flips the favorite flag
 * - Redirects back to dashboard with status
 */

require_once '../includes/require_auth.php';
require_once '../includes/db.php';

// Enable detailed error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../dashboard.php?status=invalid_method");
    exit;
}

// Validate message ID from POST
$messageId = $_POST['message_id'] ?? null;
$userId = $_SESSION['user']['id'];

if (!$messageId || !is_numeric($messageId)) {
    error_log("Invalid or missing message_id in POST: " . var_export($messageId, true));
    header("Location: ../dashboard.php?status=invalid_id");
    exit;
}

try {
    $pdo = getPDO();

    // Confirm the message exists and belongs to the current user
    $stmt = $pdo->prepare("SELECT is_favorite FROM messages WHERE id = ? AND user_id = ?");
    $stmt->execute([$messageId, $userId]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$message) {
        error_log("Message not found or unauthorized access attempt for ID: $messageId by user $userId");
        header("Location: ../dashboard.php?status=notfound");
        exit;
    }

    // Toggle favorite status (1 -> 0, or 0 -> 1)
    $currentStatus = (int)$message['is_favorite'];
    $newStatus = $currentStatus === 1 ? 0 : 1;

    $update = $pdo->prepare("UPDATE messages SET is_favorite = ? WHERE id = ? AND user_id = ?");
    $update->execute([$newStatus, $messageId, $userId]);

    error_log("User $userId toggled favorite status for message $messageId to $newStatus");

    // Redirect to dashboard with success status
    header("Location: ../dashboard.php?status=fav-updated");
    exit;
} catch (PDOException $e) {
    error_log("Database error while toggling favorite: " . $e->getMessage());
    header("Location: ../dashboard.php?status=db_error");
    exit;
}

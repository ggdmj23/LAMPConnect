<?php

/**
 * update_profile.php
 * ------------------
 * Processes the profile update form submission.
 * Validates input and updates user data in the database
 * after verifying the current password.
 */

// === DEVELOPMENT ONLY (Uncomment for debugging) ===
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../includes/require_auth.php';
require_once '../includes/db.php';

$pdo = getPDO();
$userId = $_SESSION['user']['id'];

// Sanitize and validate input
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$currentPassword = $_POST['current_password'] ?? '';

if (empty($username) || empty($email) || empty($currentPassword)) {
    header('Location: ../edit_profile.php?status=error&reason=empty');
    exit;
}

// OPTIONAL: Extra validation (recommended in production)
/*
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../edit_profile.php?status=error&reason=invalid_email');
    exit;
}
*/

// Fetch hashed password from database
$stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify password
if (!$user || !password_verify($currentPassword, $user['password'])) {
    header('Location: ../edit_profile.php?status=error&reason=wrongpass');
    exit;
}

// Prepare update query using placeholders
$sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
$params = [
    ':username' => $username,
    ':email' => $email,
    ':id' => $userId
];

try {
    // Execute update
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Update session data
    $_SESSION['user']['name'] = $username;
    $_SESSION['user']['email'] = $email;

    header('Location: ../edit_profile.php?status=success');
    exit;
} catch (PDOException $e) {
    // Log the error server-side if needed
    // error_log($e->getMessage());
    header('Location: ../edit_profile.php?status=error&reason=server');
    exit;
}

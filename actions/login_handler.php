<?php

/**
 * login_handler.php
 * -----------------
 * Securely handles user login:
 * - Validates user input
 * - Authenticates credentials (username or email + password)
 * - Starts a secure session
 * - Stores user info in session
 * - Redirects users based on role
 */

require_once '../includes/db.php';
require_once '../includes/logger.php';

session_start();
session_regenerate_id(true); // ✅ Prevents session fixation attacks

// === Step 1: Sanitize & Validate Input ===
$identifier = trim($_POST['identifier'] ?? '');
$password   = $_POST['password'] ?? '';

// Redirect if either field is empty
if (empty($identifier) || empty($password)) {
    app_log("Empty login fields submitted", 'WARN');
    header('Location: ../login.php?status=error&reason=empty');
    exit;
}

// === Step 2: Fetch User Record ===
$pdo = getPDO();

try {
    $stmt = $pdo->prepare("
        SELECT id, username, email, password, role
        FROM users
        WHERE username = :identifier OR email = :identifier
        LIMIT 1
    ");
    $stmt->execute([':identifier' => $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // === Step 3: Verify Password ===
    if (!$user || !password_verify($password, $user['password'])) {
        app_log("Failed login attempt for identifier: '$identifier'", 'WARN');
        header('Location: ../login.php?status=error&reason=invalid');
        exit;
    }

    // === Step 4: Store Safe Session Info ===
    $_SESSION['user'] = [
        'id'    => $user['id'],
        'name'  => $user['username'],
        'email' => $user['email'],
        'role'  => $user['role']
    ];

    app_log("User '{$user['username']}' (Role: {$user['role']}) logged in successfully", 'INFO');

    // === Step 5: Redirect Based on Role ===
    switch ($user['role']) {
        case 'super_admin':
        case 'admin':
            header('Location: ../admin-panel.php');
            break;
        default:
            header('Location: ../dashboard.php');
            break;
    }

    exit;
} catch (PDOException $e) {
    app_log("Login error for '$identifier': " . $e->getMessage(), 'ERROR');
    header('Location: ../login.php?status=error&reason=server');
    exit;
}

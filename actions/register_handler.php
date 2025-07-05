<?php

/**
 * register_handler.php
 * --------------------
 * Handles secure user registration:
 * - Validates & sanitizes input
 * - Checks for existing username/email
 * - Hashes password
 * - Inserts user with default role 'user'
 * - Redirects based on success or error
 */

require_once '../includes/db.php';
require_once '../includes/logger.php'; // ✅ Logging support

// === Step 1: Sanitize & Validate Input ===
$username         = trim($_POST['username'] ?? '');
$email            = trim($_POST['email'] ?? '');
$password         = $_POST['password'] ?? '';
$confirmPassword  = $_POST['confirm_password'] ?? '';

// === Check for empty fields ===
if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
    app_log("Registration failed: missing fields", 'WARN');
    header('Location: ../register.php?status=error&reason=empty');
    exit;
}

// === Check password match ===
if ($password !== $confirmPassword) {
    app_log("Registration failed: password mismatch for '$username'", 'WARN');
    header('Location: ../register.php?status=error&reason=nomatch');
    exit;
}

// === Validate email format ===
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    app_log("Registration failed: invalid email format for '$email'", 'WARN');
    header('Location: ../register.php?status=error&reason=invalid_email');
    exit;
}

$pdo = getPDO();

try {
    // === Step 2: Check if username or email already exists ===
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM users 
        WHERE username = :username OR email = :email
    ");
    $stmt->execute([
        ':username' => $username,
        ':email'    => $email
    ]);

    $userExists = $stmt->fetchColumn();

    if ($userExists) {
        app_log("Registration blocked: '$username' or '$email' already exists", 'WARN');
        header('Location: ../register.php?status=error&reason=exists');
        exit;
    }

    // === Step 3: Hash Password & Insert User ===
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insert = $pdo->prepare("
        INSERT INTO users (username, email, password, role, created_at)
        VALUES (:username, :email, :password, 'user', NOW())
    ");
    $insert->execute([
        ':username' => $username,
        ':email'    => $email,
        ':password' => $hashedPassword
    ]);

    app_log("User '$username' registered successfully", 'INFO');

    // ✅ Redirect to login with success message
    header('Location: ../login.php?status=success');
    exit;

} catch (PDOException $e) {
    app_log("Registration DB error for '$username': " . $e->getMessage(), 'ERROR');
    header('Location: ../register.php?status=error&reason=insertfail');
    exit;
}

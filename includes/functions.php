<?php

/**
 * functions.php
 * -------------
 * Utility functions for general-purpose input handling and sanitization.
 */

/**
 * Sanitize user input by trimming whitespace and escaping HTML special characters.
 *
 * This is useful to prevent XSS (Cross-Site Scripting) attacks by escaping tags like <script>.
 *
 * @param string $input Raw user input from forms or query parameters.
 * @return string Safe, trimmed, and escaped string.
 */

// Sanitize form input
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user']);
}

// Get the currently logged-in user's ID (if any)
function getCurrentUserId() {
    return $_SESSION['user']['id'] ?? null;
}

// Check if the logged-in user is a super admin
function isSuperAdmin() {
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'super_admin';
}

// Check if the logged-in user is at least an admin
function isAdmin() {
    return isset($_SESSION['user']['role']) && in_array($_SESSION['user']['role'], ['admin', 'super_admin']);
}


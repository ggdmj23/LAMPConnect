<?php

/**
 * auth_utils.php
 * --------------
 * Centralized authentication, session checking, and input sanitization utilities.
 */

// Start the session if it's not already started
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Check if the user is currently authenticated.
 *
 * @return bool True if a user session exists, false otherwise.
 */
function isAuthenticated(): bool {
    return isset($_SESSION['user']);
}

/**
 * Check if the current user session contains a valid ID and role.
 *
 * @return bool True if valid, false otherwise.
 */
function isValidUserSession(): bool {
    return isset($_SESSION['user']['id'], $_SESSION['user']['role']);
}

/**
 * Get the current user data from the session.
 *
 * @return array|null User data array if available, null otherwise.
 */
function getCurrentUser(): ?array {
    return $_SESSION['user'] ?? null;
}

/**
 * Get the current user's ID.
 *
 * @return int|null User ID if available, null otherwise.
 */
function getCurrentUserId(): ?int {
    return $_SESSION['user']['id'] ?? null;
}

/**
 * Get the current user's role.
 *
 * @return string|null Role string (e.g., 'admin'), or null if not set.
 */
function getUserRole(): ?string {
    return $_SESSION['user']['role'] ?? null;
}

/**
 * Check if the user has a specific role.
 *
 * @param string $role The role to check (e.g., 'admin').
 * @return bool True if the user has the role, false otherwise.
 */
function hasRole(string $role): bool {
    return getUserRole() === $role;
}

/**
 * Check if the user has any of the specified roles.
 *
 * @param array $roles List of roles to check against.
 * @return bool True if the user has one of the roles, false otherwise.
 */
function hasAnyRole(array $roles): bool {
    return in_array(getUserRole(), $roles, true);
}

/**
 * Check if the user is a super admin.
 *
 * @return bool True if role is 'super_admin'.
 */
function isSuperAdmin(): bool {
    return getUserRole() === 'super_admin';
}

/**
 * Check if the user is an admin or super admin.
 *
 * @return bool True if role is 'admin' or 'super_admin'.
 */
function isAdmin(): bool {
    return in_array(getUserRole(), ['admin', 'super_admin'], true);
}

/**
 * Sanitize user input (e.g., from $_POST or $_GET).
 *
 * @param string $input Raw user input
 * @return string Clean, trimmed, and escaped input
 */
function sanitizeInput(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}


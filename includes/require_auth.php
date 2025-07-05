<?php

/**
 * require_auth.php
 * ----------------
 * Access control script to ensure the user is authenticated.
 * Redirects to login if no valid user session is found.
 */

require_once __DIR__ . '/auth_utils.php';

// Redirect to login if the user is not authenticated
if (!isAuthenticated() || !isValidUserSession()) {
    // Redirect to login if session is missing or invalid
    header('Location: login.php?status=unauthenticated');
    exit;
}

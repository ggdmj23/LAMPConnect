<?php

/**
 * require_super_admin.php
 * ------------------------
 * Access control script to restrict access to super admin users only.
 * Redirects to login page with a status message if unauthorized.
 */

require_once __DIR__ . '/auth_utils.php';

// Redirect if the user is not a super admin
if (!hasRole('super_admin')) {
    header('Location: login.php?status=unauthorized');
    exit;
}

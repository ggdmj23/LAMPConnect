<?php

/**
 * require_admin.php
 * -----------------
 * Access control script to ensure the user has admin-level access.
 * Allows both 'admin' and 'super_admin' roles.
 * Redirects to login with status if unauthorized.
 */

require_once __DIR__ . '/auth_utils.php';

// Redirect if the user is not an admin or super admin
if (!hasAnyRole(['admin', 'super_admin'])) {
    header('Location: login.php?status=unauthorized');
    exit;
}

<?php

/**
 * test_msmtp.php
 * --------------
 * Safely sends a test email using the configured msmtp setup.
 * Uses sendContactEmail() from mail.php.
 * Logs results to log.txt.
 */

require_once 'includes/mail.php';  // Uses ADMIN_EMAIL from config.php

// === Test data ===
$testName    = 'Test User';
$testEmail   = 'gonmj23@gmail.com'; // Can be your real test address
$testMessage = 'This is a test email from msmtp integration check.';

// === Attempt to send ===
$success = sendContactEmail($testEmail, $testName, $testMessage);

// === Output generic result ===
if ($success) {
    echo '<p style="color:green;">✅ Test email sent successfully.</p>';
} else {
    echo '<p style="color:red;">❌ Failed to send test email. Check log.txt for details.</p>';
}

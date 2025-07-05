<?php

/**
 * mail.php
 * --------
 * Sends contact form messages using msmtp.
 * Requires centralized ADMIN_EMAIL defined in config.
 */

require_once __DIR__ . '/../../LAMPConnect-secure/config.php';

/**
 * Send an email using msmtp from the contact form submission.
 *
 * @param string $fromEmail The sender's email address.
 * @param string $name      The sender's name.
 * @param string $message   The message content.
 * @return bool             True if the email was sent successfully, false otherwise.
 */
function sendContactEmail(string $fromEmail, string $name, string $message): bool
{
    $to = ADMIN_EMAIL;

    // === Compose Email ===
    $subject = "New Contact Form Message from " . $name;
    $headers = "From: $fromEmail\r\nReply-To: $fromEmail\r\n";
    $body = "To: $to\r\nSubject: $subject\r\n$headers\r\nMessage:\r\n$message";

    // === Send Using msmtp ===
    $cmd = "/usr/bin/msmtp -t";
    $process = popen($cmd, 'w');

    if (!$process) {
        logMailStatus("❌ Failed to open msmtp process");
        return false;
    }

    fwrite($process, $body);
    $status = pclose($process);

    logMailStatus("📤 Email sent with status: $status");

    return $status === 0;
}

/**
 * Log mail delivery status to file.
 *
 * @param string $entry The log message.
 */
function logMailStatus(string $entry): void
{
    $logPath = __DIR__ . '/../logs/log.txt';
    $timestamp = date('[Y-m-d H:i:s]');
    file_put_contents($logPath, "$timestamp $entry\n", FILE_APPEND | LOCK_EX);
}

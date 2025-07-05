<?php
/**
 * logger.php
 * ----------
 * Custom logging utility for LAMPConnect.
 * Logs messages to a private log file in /logs with timestamp and level.
 */

function app_log(string $message, string $level = 'INFO'): void {
    // Log file path (change if needed)
    $logFile = __DIR__ . '/../logs/log.txt';

    // Format: [YYYY-MM-DD HH:MM:SS][LEVEL] Message
    $timestamp = date('Y-m-d H:i:s');
    $formatted = "[$timestamp][$level] $message" . PHP_EOL;

    // Append to log file (3 = append mode)
    error_log($formatted, 3, $logFile);
}

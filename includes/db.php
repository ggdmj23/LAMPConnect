<?php

/**
 * Database Connection File
 * ------------------------
 * Provides a reusable function to establish a PDO connection
 * using the constants defined in config.php.
 */

//require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../../LAMPConnect-secure/config.php';


/**
 * getPDO
 * -------
 * Creates and returns a PDO instance for connecting to the MySQL database.
 *
 * @return PDO The configured PDO database connection
 * @throws PDOException on connection failure (caught and handled)
 */
function getPDO(): PDO
{
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Optional: Enable persistent connection
        // $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);

        return $pdo;
    } catch (PDOException $e) {
        /*
        $logFile = __DIR__ . '/../logs/db_errors.log';
        echo "Resolved log path: $logFile<br>";
        echo "Writable? " . (is_writable($logFile) ? 'YES' : 'NO') . "<br>";
        */
        $logFile = __DIR__ . '/../logs/db_errors.log'; // absolute path
        /*
        if (!is_writable($logFile)) {
            error_log("Cannot write to log file: $logFile");
        }
        */
        $errorMsg = "[" . date('Y-m-d H:i:s') . "] DB ERROR: " . $e->getMessage() . PHP_EOL;

        file_put_contents($logFile, $errorMsg, FILE_APPEND);
        die("❌ A database error occurred. Please try again later.");
    }
}

<?php
// Enable PHP error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbPath = __DIR__ . '/../database/ichiban.db';
$dbDir = dirname($dbPath);

// Create database directory if it doesn't exist
if (!file_exists($dbDir)) {
    mkdir($dbDir, 0777, true);
}

// Create logs directory if it doesn't exist
$logDir = __DIR__ . '/../logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true);
}

function logError($message) {
    error_log($message . PHP_EOL, 3, __DIR__ . '/../logs/error.log');
}

try {
    $db = new SQLite3($dbPath);
    $db->enableExceptions(true);
    
    // Test the connection with a simple query
    $test = $db->query('SELECT 1');
    if (!$test) {
        throw new Exception("Database connection test failed");
    }
} catch(Exception $e) {
    logError("Database connection failed: " . $e->getMessage());
    header("HTTP/1.1 500 Internal Server Error");
    echo "Database connection error. Please try again later.";
    die();
}

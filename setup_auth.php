<?php
require_once 'config/database.php';

try {
    // Create auth_sessions table if it doesn't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS auth_sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            token TEXT NOT NULL UNIQUE,
            expires_at DATETIME NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");

    // Create users table if it doesn't exist (in case it wasn't created)
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Create a test user if none exists
    $db->exec("
        INSERT OR IGNORE INTO users (username, email, password)
        VALUES ('demo', 'demo@example.com', '" . password_hash('demo123', PASSWORD_DEFAULT) . "')
    ");

    // Clear expired sessions
    $db->exec("DELETE FROM auth_sessions WHERE expires_at < datetime('now')");

    echo "Authentication system setup completed successfully!";

} catch(Exception $e) {
    echo "Setup failed: " . $e->getMessage();
}
?>

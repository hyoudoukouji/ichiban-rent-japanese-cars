<?php
require_once 'config/database.php';

try {
    // Create rentals table
    $db->exec("
        CREATE TABLE IF NOT EXISTS rentals (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            car_id INTEGER NOT NULL,
            rental_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            return_date DATETIME,
            status TEXT DEFAULT 'active',
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    echo "Rentals table created successfully!";

} catch(Exception $e) {
    echo "Setup failed: " . $e->getMessage();
}
?>

<?php
header('Content-Type: application/json');
require_once __DIR__ . '/functions.php';

try {
    // Validate input
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception('All fields are required');
    }

    $username = trim($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Validate username
    if (strlen($username) < 3) {
        throw new Exception('Username must be at least 3 characters long');
    }

    // Validate email
    if (!$email) {
        throw new Exception('Invalid email format');
    }

    // Validate password
    if (strlen($password) < 6) {
        throw new Exception('Password must be at least 6 characters long');
    }

    // Check if email already exists
    $stmt = $db->prepare('SELECT COUNT(*) as count FROM users WHERE email = ?');
    $stmt->bindValue(1, $email);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row['count'] > 0) {
        throw new Exception('Email already registered');
    }

    // Check if username already exists
    $stmt = $db->prepare('SELECT COUNT(*) as count FROM users WHERE username = ?');
    $stmt->bindValue(1, $username);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row['count'] > 0) {
        throw new Exception('Username already taken');
    }

    // Hash password
    $hashedPassword = hashPassword($password);

    // Begin transaction
    $db->exec('BEGIN TRANSACTION');
    
    try {
        // Insert new user
        $stmt = $db->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $hashedPassword);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to create user account');
        }

        $db->exec('COMMIT');
    } catch (Exception $e) {
        $db->exec('ROLLBACK');
        throw $e;
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Registration successful'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

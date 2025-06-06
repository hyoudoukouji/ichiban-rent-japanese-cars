<?php
header('Content-Type: application/json');
require_once __DIR__ . '/functions.php';

try {
    // Validate input
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception('Email and password are required');
    }

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception('Invalid email format');
    }

    // Get user by email
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bindValue(1, $email);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if (!$user) {
        throw new Exception('Invalid email or password');
    }

    // Verify password
    if (!verifyPassword($_POST['password'], $user['password'])) {
        throw new Exception('Invalid email or password');
    }

    // Create session and set cookie
    $token = createSession($user['id']);
    setAuthCookie($token);

    // Return success response
    echo json_encode([
        'success' => true,
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

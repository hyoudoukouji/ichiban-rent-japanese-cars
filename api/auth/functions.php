<?php
require_once __DIR__ . '/../../config/database.php';

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function createSession($userId) {
    global $db;
    
    $token = generateToken();
    $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));
    
    $stmt = $db->prepare('INSERT INTO auth_sessions (user_id, token, expires_at) VALUES (?, ?, ?)');
    $stmt->bindValue(1, $userId);
    $stmt->bindValue(2, $token);
    $stmt->bindValue(3, $expiresAt);
    $stmt->execute();
    
    return $token;
}

function validateSession($token) {
    global $db;
    
    $stmt = $db->prepare('
        SELECT users.* 
        FROM users 
        JOIN auth_sessions ON users.id = auth_sessions.user_id 
        WHERE auth_sessions.token = ? 
        AND auth_sessions.expires_at > datetime("now")
    ');
    $stmt->bindValue(1, $token);
    $result = $stmt->execute();
    
    return $result->fetchArray(SQLITE3_ASSOC);
}

function getCurrentUser() {
    if (!isset($_COOKIE['auth_token'])) {
        return null;
    }
    
    return validateSession($_COOKIE['auth_token']);
}

function requireAuth() {
    $user = getCurrentUser();
    if (!$user) {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['message' => 'Authentication required']);
        exit;
    }
    return $user;
}

function setAuthCookie($token) {
    setcookie('auth_token', $token, [
        'expires' => time() + (30 * 24 * 60 * 60), // 30 days
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

function clearAuthCookie() {
    setcookie('auth_token', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}

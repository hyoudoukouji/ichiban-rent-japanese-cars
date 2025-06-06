<?php
header('Content-Type: application/json');
require_once __DIR__ . '/functions.php';

try {
    // Get current token
    $token = $_COOKIE['auth_token'] ?? null;
    
    if ($token) {
        // Delete session from database
        $stmt = $db->prepare('DELETE FROM auth_sessions WHERE token = ?');
        $stmt->bindValue(1, $token);
        $stmt->execute();
        
        // Clear auth cookie
        clearAuthCookie();
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

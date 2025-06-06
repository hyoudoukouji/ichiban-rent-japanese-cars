<?php
header('Content-Type: application/json');
require_once __DIR__ . '/functions.php';

try {
    $user = getCurrentUser();
    
    if ($user) {
        echo json_encode([
            'authenticated' => true,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ]
        ]);
    } else {
        echo json_encode([
            'authenticated' => false
        ]);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'authenticated' => false,
        'message' => $e->getMessage()
    ]);
}

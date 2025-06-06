<?php
session_start();
require_once '../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/../../api/auth/functions.php';

$currentUser = getCurrentUser();
if (!$currentUser) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$required_fields = ['name', 'email', 'phone', 'address'];
foreach ($required_fields as $field) {
    if (!isset($data[$field]) || empty(trim($data[$field]))) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required field: {$field}"]);
        exit;
    }
}

try {
    // Update user profile in database
    $stmt = $db->prepare('UPDATE users SET 
        name = :name, 
        email = :email, 
        phone = :phone, 
        address = :address,
        preferred_cars = :preferred_cars
        WHERE id = :id');
    
    $preferred_cars = isset($data['preferred_cars']) ? json_encode($data['preferred_cars']) : '[]';
    
    $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
    $stmt->bindValue(':email', $data['email'], SQLITE3_TEXT);
    $stmt->bindValue(':phone', $data['phone'], SQLITE3_TEXT);
    $stmt->bindValue(':address', $data['address'], SQLITE3_TEXT);
    $stmt->bindValue(':preferred_cars', $preferred_cars, SQLITE3_TEXT);
    $stmt->bindValue(':id', $currentUser['id'], SQLITE3_INTEGER);
    
    $result = $stmt->execute();
    
    echo json_encode([
        'success' => true,
        'message' => 'Profile updated successfully'
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to update profile',
        'details' => $e->getMessage()
    ]);
}
?>

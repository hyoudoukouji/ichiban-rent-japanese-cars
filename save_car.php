<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

$carId = isset($_POST['car_id']) ? (int)$_POST['car_id'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;
$userId = 1; // For now, we'll use a default user ID since we don't have authentication yet

if (!$carId || !$action) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit();
}

try {
    if ($action === 'add') {
        // Check if already saved
        $stmt = $db->prepare("SELECT id FROM saved_cars WHERE user_id = :user_id AND car_id = :car_id");
        if (!$stmt) {
            throw new Exception("Failed to prepare select statement: " . $db->lastErrorMsg());
        }
        
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':car_id', $carId);
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Failed to execute select statement: " . $db->lastErrorMsg());
        }
        
        if (!$result->fetchArray()) {
            // Insert new saved car
            $stmt = $db->prepare("INSERT INTO saved_cars (user_id, car_id) VALUES (:user_id, :car_id)");
            if (!$stmt) {
                throw new Exception("Failed to prepare insert statement: " . $db->lastErrorMsg());
            }
            
            $stmt->bindValue(':user_id', $userId);
            $stmt->bindValue(':car_id', $carId);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute insert statement: " . $db->lastErrorMsg());
            }
            
            // Update session
            if (!isset($_SESSION['saved_cars'])) {
                $_SESSION['saved_cars'] = [];
            }
            $_SESSION['saved_cars'][] = $carId;
        }
    } elseif ($action === 'remove') {
        // Remove from database
        $stmt = $db->prepare("DELETE FROM saved_cars WHERE user_id = :user_id AND car_id = :car_id");
        if (!$stmt) {
            throw new Exception("Failed to prepare delete statement: " . $db->lastErrorMsg());
        }
        
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':car_id', $carId);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute delete statement: " . $db->lastErrorMsg());
        }
        
        // Update session
        if (isset($_SESSION['saved_cars'])) {
            $_SESSION['saved_cars'] = array_values(array_diff($_SESSION['saved_cars'], [$carId]));
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => $action === 'add' ? 'Car saved successfully' : 'Car removed successfully'
    ]);
} catch(Exception $e) {
    error_log("Error in save_car.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}

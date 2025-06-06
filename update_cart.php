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

if (!$carId || !$action) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit();
}

try {
    if ($action === 'add') {
        // Initialize cart array in session if it doesn't exist
        if (!isset($_SESSION['cart_items'])) {
            $_SESSION['cart_items'] = [];
        }
        
        // Get rental dates from POST data
        $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : null;
        $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : null;
        $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 1;
        
        // If no dates provided, set default to today + 1 day
        if (!$startDate || !$endDate) {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+1 day'));
            $duration = 1;
        }
        
        // Store cart item with rental information
        $_SESSION['cart_items'][$carId] = [
            'car_id' => $carId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration' => $duration,
            'added_at' => date('Y-m-d H:i:s')
        ];
        
        echo json_encode([
            'success' => true,
            'message' => 'Car added to cart successfully',
            'rental_info' => $_SESSION['cart_items'][$carId]
        ]);
    } elseif ($action === 'remove') {
        // Remove car from cart
        if (isset($_SESSION['cart_items'][$carId])) {
            unset($_SESSION['cart_items'][$carId]);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Car removed from cart successfully'
        ]);
    } elseif ($action === 'update_dates') {
        // Update rental dates for existing cart item
        if (isset($_SESSION['cart_items'][$carId])) {
            $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : $_SESSION['cart_items'][$carId]['start_date'];
            $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : $_SESSION['cart_items'][$carId]['end_date'];
            
            // Calculate duration
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $duration = $start->diff($end)->days + 1;
            
            $_SESSION['cart_items'][$carId]['start_date'] = $startDate;
            $_SESSION['cart_items'][$carId]['end_date'] = $endDate;
            $_SESSION['cart_items'][$carId]['duration'] = $duration;
            
            echo json_encode([
                'success' => true,
                'message' => 'Rental dates updated successfully',
                'rental_info' => $_SESSION['cart_items'][$carId]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Car not found in cart'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action'
        ]);
    }
} catch(Exception $e) {
    error_log("Error in update_cart.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Server error occurred'
    ]);
}

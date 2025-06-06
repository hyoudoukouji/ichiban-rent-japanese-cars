<?php
session_start();
require_once 'config/database.php';

// Get parameters from URL or POST
$carId = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
$duration = isset($_GET['duration']) ? (int)$_GET['duration'] : 0;
$rentalStart = isset($_GET['start']) ? $_GET['start'] : '';
$rentalEnd = isset($_GET['end']) ? $_GET['end'] : '';

if ($carId <= 0 || $duration <= 0 || !$rentalStart || !$rentalEnd) {
    die("Invalid rental details.");
}

try {
    // Fetch car details
    $stmt = $db->prepare("SELECT * FROM cars WHERE id = :car_id");
    $stmt->bindValue(':car_id', $carId, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $car = $result->fetchArray(SQLITE3_ASSOC);
    if (!$car) {
        die("Car not found.");
    }
} catch (Exception $e) {
    die("Error loading car details.");
}

// Extract numeric price from formatted price string (e.g., "Rp 9.890.000")
function extractPrice($priceStr) {
    return (float)preg_replace('/[^0-9]/', '', $priceStr);
}

$pricePerDay = extractPrice($car['price']);
$totalPrice = $pricePerDay * $duration;

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate payment form inputs
    $cardName = trim($_POST['cardName'] ?? '');
    $cardNumber = trim($_POST['cardNumber'] ?? '');
    $expiry = trim($_POST['expiry'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    if (!$cardName) $errors[] = "Cardholder name is required.";
    if (!preg_match('/^\d{16}$/', $cardNumber)) $errors[] = "Card number must be 16 digits.";
    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)) $errors[] = "Expiry date must be in MM/YY format.";
    if (!preg_match('/^\d{3,4}$/', $cvv)) $errors[] = "CVV must be 3 or 4 digits.";

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO rentals (user_id, car_id, rental_start, rental_end, total_price, status) VALUES (:user_id, :car_id, :rental_start, :rental_end, :total_price, 'confirmed')");
            $stmt->bindValue(':user_id', null, SQLITE3_NULL);
            $stmt->bindValue(':car_id', $carId, SQLITE3_INTEGER);
            $stmt->bindValue(':rental_start', $rentalStart);
            $stmt->bindValue(':rental_end', $rentalEnd);
            $stmt->bindValue(':total_price', $totalPrice);
            $stmt->execute();

            $success = true;
        } catch (Exception $e) {
            $errors[] = "Failed to save rental: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout - Ichiban Rent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-4 flex items-center justify-between">
                <a href="index.php" class="text-2xl font-bold">Ichiban Rent</a>
                <nav class="space-x-4">
                    <a href="index.php" class="hover:text-gray-700">Home</a>
                    <a href="explore.php" class="hover:text-gray-700">Explore</a>
                    <a href="saved.php" class="hover:text-gray-700">Saved</a>
                    <a href="rent.php" class="font-semibold hover:text-gray-700">Rent</a>
                    <a href="profile.php" class="hover:text-gray-700">Profile</a>
                </nav>
            </div>
        </header>

        <main class="checkout-container">
            <div class="checkout-summary">
                <h1 class="text-3xl font-bold mb-6">Checkout</h1>

                <?php if ($success): ?>
                    <div class="success-message">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline"> Your rental has been confirmed. Thank you for choosing Ichiban Rent.</span>
                    </div>
                    <a href="index.php" class="checkout-btn">Back to Home</a>
                <?php else: ?>
                    <?php if (!empty($errors)): ?>
                    <div class="error-message">
                            <ul class="list-disc list-inside">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4">Rental Summary</h2>
                        <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded">
                            <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="w-32 h-20 object-contain" />
                            <div>
                                <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($car['name']); ?></h3>
                                <p class="text-gray-600">Rental Period: <?php echo htmlspecialchars($rentalStart); ?> to <?php echo htmlspecialchars($rentalEnd); ?></p>
                                <p class="text-gray-600">Duration: <?php echo $duration; ?> day<?php echo $duration > 1 ? 's' : ''; ?></p>
                                <p class="text-gray-600">Price per day: Rp <?php echo number_format($pricePerDay, 0, ',', '.'); ?></p>
                                <p class="font-semibold mt-1">Total Price: Rp <?php echo number_format($totalPrice, 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" class="checkout-form" novalidate>
                        <h2 class="text-xl font-semibold mb-4">Payment Information</h2>
                        <div class="form-group">
                            <label for="cardName">Cardholder Name</label>
                            <input type="text" id="cardName" name="cardName" required />
                        </div>
                        <div class="form-group">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" id="cardNumber" name="cardNumber" maxlength="16" pattern="\d{16}" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="expiry">Expiry Date (MM/YY)</label>
                                <input type="text" id="expiry" name="expiry" pattern="(0[1-9]|1[0-2])\/\d{2}" placeholder="MM/YY" required />
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" maxlength="4" pattern="\d{3,4}" required />
                            </div>
                        </div>
                        <button type="submit" class="checkout-btn">
                            Pay Now
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        // Format card number with spaces
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 16);
        });

        // Format expiry date
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // Format CVV
        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
        });
    </script>
</body>
</html>

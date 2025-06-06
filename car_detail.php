<?php
session_start();
require_once 'config/database.php';

$carId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($carId <= 0) {
    die("Invalid car ID.");
}

try {
    $query = "
        SELECT c.*, GROUP_CONCAT(cf.feature) as features
        FROM cars c
        LEFT JOIN car_features cf ON c.id = cf.car_id
        WHERE c.id = :car_id
        GROUP BY c.id
    ";
    $stmt = $db->prepare($query);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $db->lastErrorMsg());
    }
    $stmt->bindValue(':car_id', $carId);
    $result = $stmt->execute();
    $car = $result->fetchArray(SQLITE3_ASSOC);
    if (!$car) {
        die("Car not found.");
    }
    $car['features'] = $car['features'] ? explode(',', $car['features']) : [];
    $car['specs'] = [
        'engine' => $car['engine'],
        'power' => $car['power'],
        'transmission' => $car['transmission']
    ];
} catch (Exception $e) {
    error_log("Error fetching car details: " . $e->getMessage());
    die("Error loading car details.");
}

// Check if car is saved in session
$savedCars = isset($_SESSION['saved_cars']) ? $_SESSION['saved_cars'] : [];
$isSaved = in_array($carId, $savedCars);

// Extract numeric price from formatted price string (e.g., "Rp 9.890.000")
function extractPrice($priceStr) {
    return (float)preg_replace('/[^0-9]/', '', $priceStr);
}
$pricePerDay = extractPrice($car['price']);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($car['name']); ?> - Ichiban Rent</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        a { color: inherit; text-decoration: none; }
    </style>
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
                    <a href="rent.php" class="hover:text-gray-700">Rent</a>
                    <a href="profile.php" class="hover:text-gray-700">Profile</a>
                </nav>
            </div>
        </header>

        <main class="container mx-auto px-4 py-8 flex flex-col md:flex-row gap-8">
            <div class="md:w-1/2 bg-white rounded-lg shadow p-4">
                <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="w-full h-80 object-contain rounded" />
            </div>

            <div class="md:w-1/2 bg-white rounded-lg shadow p-6 flex flex-col">
                <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($car['name']); ?></h1>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($car['category']); ?></p>
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 flex items-center space-x-1">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <?php if ($i < (int)$car['rating']): ?>
                                <i class="fas fa-star"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <span class="ml-2 text-gray-700 font-semibold"><?php echo htmlspecialchars($car['rating']); ?>/5</span>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Specifications</h2>
                    <ul class="list-disc list-inside space-y-1 text-gray-700">
                        <?php foreach ($car['specs'] as $key => $value): ?>
                            <li><strong><?php echo ucfirst(htmlspecialchars($key)); ?>:</strong> <?php echo htmlspecialchars($value); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Advantages</h2>
                    <ul class="list-none list-inside space-y-1 text-gray-700">
                        <?php foreach ($car['features'] as $feature): ?>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L9 14.414l-3.707-3.707a1 1 0 00-1.414 1.414l4.414 4.414a1 1 0 001.414 0l8.414-8.414a1 1 0 00-1.414-1.414z" clip-rule="evenodd" />
                            </svg>
                            <span><?php echo htmlspecialchars($feature); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Rental Period</h2>
                    <div class="flex space-x-4 items-center">
                        <div class="flex-1">
                            <label for="rentalStart" class="block text-sm font-medium mb-1">Start Date</label>
                            <input type="date" id="rentalStart" name="rentalStart" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        </div>
                        <span class="text-gray-700 font-semibold">to</span>
                        <div class="flex-1">
                            <label for="rentalEnd" class="block text-sm font-medium mb-1">End Date</label>
                            <input type="date" id="rentalEnd" name="rentalEnd" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-600">Price per day: <span class="font-semibold">Rp <?php echo number_format($pricePerDay, 0, ',', '.'); ?></span></p>
                        <p class="text-lg font-semibold mt-1">Total Price: <span id="totalPrice">Rp 0</span></p>
                    </div>
                </div>

                <div class="mt-auto flex space-x-4 items-center">
                    <button id="rentNowBtn" class="flex-1 bg-black text-white py-3 rounded hover:bg-gray-800 transition duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-credit-card"></i>
                        <span>Rent Now</span>
                    </button>
                    <button id="addToCartBtn" class="flex-1 border border-black text-black py-3 rounded hover:bg-black hover:text-white transition duration-300 flex items-center justify-center" title="Add to Cart">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                    <button id="wishlistBtn" class="text-black hover:text-red-600 transition duration-300 ml-4 text-2xl <?php echo $isSaved ? 'text-red-600' : ''; ?>" title="Wishlist" aria-label="Wishlist">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        const carId = <?php echo $carId; ?>;
        const pricePerDay = <?php echo $pricePerDay; ?>;
        const rentNowBtn = document.getElementById('rentNowBtn');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const wishlistBtn = document.getElementById('wishlistBtn');
        const rentalStartInput = document.getElementById('rentalStart');
        const rentalEndInput = document.getElementById('rentalEnd');
        const totalPriceElement = document.getElementById('totalPrice');

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        rentalStartInput.min = today;
        rentalEndInput.min = today;

        function calculateTotal() {
            const startDate = new Date(rentalStartInput.value);
            const endDate = new Date(rentalEndInput.value);
            
            if (rentalStartInput.value && rentalEndInput.value) {
                if (endDate < startDate) {
                    totalPriceElement.textContent = 'Invalid dates';
                    return 0;
                }
                const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                const total = pricePerDay * duration;
                totalPriceElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
                return duration;
            }
            return 0;
        }

        rentalStartInput.addEventListener('change', calculateTotal);
        rentalEndInput.addEventListener('change', calculateTotal);

        rentNowBtn.addEventListener('click', () => {
            const startDate = rentalStartInput.value;
            const endDate = rentalEndInput.value;
            const duration = calculateTotal();

            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }
            if (new Date(endDate) < new Date(startDate)) {
                alert('End date must be after start date.');
                return;
            }
            if (duration <= 0) {
                alert('Invalid rental duration.');
                return;
            }

            window.location.href = `checkout.php?car_id=${carId}&duration=${duration}&start=${startDate}&end=${endDate}`;
        });

        addToCartBtn.addEventListener('click', () => {
            addToCartBtn.disabled = true;
            fetch('update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `car_id=${carId}&action=add`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    addToCartBtn.innerHTML = '<i class="fas fa-check"></i>';
                    addToCartBtn.classList.remove('border-black');
                    addToCartBtn.classList.add('bg-green-600', 'border-green-600', 'text-white');
                    setTimeout(() => {
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart"></i>';
                        addToCartBtn.classList.remove('bg-green-600', 'border-green-600', 'text-white');
                        addToCartBtn.classList.add('border-black');
                        addToCartBtn.disabled = false;
                    }, 2000);
                } else {
                    alert('Failed to add to cart: ' + (data.error || 'Unknown error'));
                    addToCartBtn.disabled = false;
                }
            })
            .catch(() => {
                alert('Network error: Failed to add to cart.');
                addToCartBtn.disabled = false;
            });
        });

        wishlistBtn.addEventListener('click', () => {
            const isWishlisted = wishlistBtn.classList.contains('text-red-600');
            wishlistBtn.disabled = true;
            fetch('save_car.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `car_id=${carId}&action=${isWishlisted ? 'remove' : 'add'}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    wishlistBtn.classList.toggle('text-red-600');
                } else {
                    alert('Failed to update wishlist: ' + (data.error || 'Unknown error'));
                }
                wishlistBtn.disabled = false;
            })
            .catch(() => {
                alert('Network error: Failed to update wishlist.');
                wishlistBtn.disabled = false;
            });
        });
    </script>
</body>
</html>

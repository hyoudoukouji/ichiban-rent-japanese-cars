<?php
session_start();
require_once __DIR__ . '/config/database.php';

// Initialize variables
$cars = [];
$featuredCar = null;
$error = null;

try {
    // Use prepared statements for better security
    $featuredQuery = $db->prepare('SELECT * FROM cars ORDER BY rating DESC LIMIT 1');
    $carsQuery = $db->prepare('SELECT * FROM cars ORDER BY rating DESC LIMIT 6 OFFSET 1');
    
    if (!$featuredQuery || !$carsQuery) {
        throw new Exception("Failed to prepare database queries");
    }

    // Execute queries with timeout
    $startTime = microtime(true);
    $result = $featuredQuery->execute();
    
    if ($result) {
        $featuredCar = $result->fetchArray(SQLITE3_ASSOC);
    }

    $result = $carsQuery->execute();
    if ($result) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $cars[] = $row;
            // Check for timeout (3 seconds max)
            if (microtime(true) - $startTime > 3) {
                throw new Exception("Query timeout exceeded");
            }
        }
    }

    // Log successful query
    error_log("Successfully fetched " . count($cars) . " cars");
    
} catch (Exception $e) {
    // Log the error
    error_log("Database query failed: " . $e->getMessage());
    $error = "Failed to load car data. Please try again later.";
    $featuredCar = null;
    $cars = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ichiban Rent - Japanese Car Rentals</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="/public/js/image-handler.js" defer></script>
</head>
<body>
    <div class="container">
        <!-- Include Navigation -->
        <?php require_once 'components/navigation.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="header-content">
                    <h1>Japan Cars</h1>
                    <p>Experience the Heart of Japan in Every Drive.</p>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Car ...." />
                    <button class="filter-btn"><i class="fas fa-sliders-h"></i></button>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile" />
                    </button>
                </div>
            </header>



            <!-- Featured Car -->
            <?php if ($featuredCar): ?>
            <section class="featured-car">
                <div class="car-details">
                    <h2><?= htmlspecialchars($featuredCar['name']) ?></h2>
                    <div class="rating">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                        <span>(2000+ Reviews)</span>
                    </div>
                    <p class="description">
                        <?= htmlspecialchars($featuredCar['engine']) ?>,
                        <?= htmlspecialchars($featuredCar['power']) ?>,
                        <?= htmlspecialchars($featuredCar['transmission']) ?>
                    </p>
                    <div class="price"><?= htmlspecialchars($featuredCar['price']) ?></div>
                    <div class="actions">
                        <div class="color-select">
                            <span>Color</span>
                            <div class="color-options">
                                <button class="color-btn white active"></button>
                                <button class="color-btn black"></button>
                            </div>
                        </div>
                        <div class="duration">
                            <button class="minus">-</button>
                            <span>1 Day</span>
                            <button class="plus">+</button>
                        </div>
                    </div>
                    <div class="rent-actions">
                        <button class="favorite-btn"><i class="far fa-heart"></i></button>
                        <button class="rent-btn">Rent now</button>
                    </div>
                </div>
                <div class="car-image">
                    <img 
                        data-src="<?= htmlspecialchars($featuredCar['image']) ?>" 
                        src="data:image/svg+xml,%3Csvg width='300' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='300' height='200' fill='%23f0f0f0'/%3E%3C/svg%3E"
                        alt="<?= htmlspecialchars($featuredCar['name']) ?>"
                        onerror="handleImageError(this)"
                    />
                </div>
            </section>
            <?php endif; ?>

            <!-- Car List -->
            <section class="car-list">
                <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <img 
                        data-src="<?= htmlspecialchars($car['image']) ?>" 
                        src="data:image/svg+xml,%3Csvg width='300' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='300' height='200' fill='%23f0f0f0'/%3E%3C/svg%3E"
                        alt="<?= htmlspecialchars($car['name']) ?>"
                        onerror="handleImageError(this)"
                    />
                    <h3><?= htmlspecialchars($car['name']) ?></h3>
                    <div class="price"><?= htmlspecialchars($car['price']) ?></div>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span><?= htmlspecialchars($car['rating']) ?></span>
                    </div>
                    <button class="add-btn">+</button>
                </div>
                <?php endforeach; ?>
            </section>

            <!-- Top Rent Section -->
            <section class="top-rent">
                <div class="section-header">
                    <h2>Top Rent</h2>
                    <a href="#" class="view-all">View all <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="top-rent-list">
                    <!-- Top rent items will be added here via JavaScript -->
                </div>
            </section>
        </main>
    </div>
    <?php require_once 'components/auth_modal.php'; ?>
    <script src="script.js"></script>
    <script>
        // Update UI based on authentication state
        document.addEventListener('DOMContentLoaded', () => {
            const profileBtn = document.querySelector('.profile-btn');
            
            // Check if user is logged in
            fetch('/api/auth/check.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Auth check response:', data);
                    if (data.authenticated) {
                        // Update profile button to show user initial
                        profileBtn.innerHTML = `
                            <div class="user-avatar"><i class="fas fa-user"></i></div>
                            <style>
                                .user-avatar {
                                    width: 40px;
                                    height: 40px;
                                    background: var(--primary-color);
                                    color: white;
                                    border-radius: var(--border-radius);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 600;
                                    font-size: 20px;
                                }
                            </style>
                        `;

                        // Add logout option
                        profileBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            if (confirm('Are you sure you want to logout?')) {
                                fetch('/api/auth/logout.php')
                                    .then(() => window.location.reload());
                            }
                        });
                    }
                })
                .catch(console.error);
        });
    </script>
</body>
</html>

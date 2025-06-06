<?php
session_start();
require_once 'config/database.php';

try {
    // Get all cars with their features
    $query = "
        SELECT c.*, GROUP_CONCAT(cf.feature) as features
        FROM cars c
        LEFT JOIN car_features cf ON c.id = cf.car_id
        GROUP BY c.id
    ";
    $result = $db->query($query);
    if (!$result) {
        throw new Exception("Failed to execute query: " . $db->lastErrorMsg());
    }
    
    $cars = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $row['features'] = $row['features'] ? explode(',', $row['features']) : [];
        $row['specs'] = [
            'engine' => $row['engine'],
            'power' => $row['power'],
            'transmission' => $row['transmission']
        ];
        $cars[] = $row;
    }
} catch(Exception $e) {
    error_log("Error fetching cars in explore.php: " . $e->getMessage());
    die("<p>Sorry, an error occurred while loading the cars. Please try again later.</p>");
}

// Get the saved cars from session if any
$savedCars = isset($_SESSION['saved_cars']) ? $_SESSION['saved_cars'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .car-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .car-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid #eee;
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .car-image-container {
            position: relative;
            height: 220px;
            background: #f8f9fa;
            overflow: hidden;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.05);
        }

        .car-details {
            padding: 1.5rem;
        }

        .car-category {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #f0f2f5;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #1a1a1a;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .car-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1a1a1a;
        }

        .car-features {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .feature-tag {
            padding: 0.4rem 0.8rem;
            background: #f0f2f5;
            border-radius: 12px;
            font-size: 0.85rem;
            color: #1a1a1a;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .feature-tag i {
            color: #1a1a1a;
        }

        .car-specs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            padding: 1rem 0;
            border-top: 1px solid #eee;
            margin-top: 1rem;
        }

        .spec-item {
            text-align: center;
        }

        .spec-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .spec-value {
            font-size: 0.95rem;
            color: #1a1a1a;
            font-weight: 500;
        }

        .car-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .price {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .actions {
            display: flex;
            gap: 1rem;
        }

        .save-btn {
            background: white;
            border: 1px solid #eee;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .save-btn:hover {
            background: #f0f2f5;
        }

        .save-btn.saved {
            background: #1a1a1a;
            border-color: #1a1a1a;
        }

        .save-btn.saved i {
            color: white;
        }

        .rent-btn {
            padding: 0 1.5rem;
            height: 40px;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rent-btn:hover {
            opacity: 0.9;
        }

        .filters {
            padding: 1.5rem 2rem;
            background: white;
            border-radius: 20px;
            margin: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            border: 1px solid #eee;
        }

        .filter-label {
            font-weight: 500;
            color: #1a1a1a;
        }

        .filter-btn {
            padding: 0.6rem 1.2rem;
            border: 1px solid #eee;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #666;
        }

        .filter-btn:hover {
            background: #f0f2f5;
            color: #1a1a1a;
        }

        .filter-btn.active {
            background: #1a1a1a;
            color: white;
            border-color: #1a1a1a;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin: 0.5rem 0;
        }

        .rating i {
            color: #1a1a1a;
            font-size: 0.9rem;
        }

        .rating span {
            font-weight: 500;
            color: #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Include Navigation -->
        <?php require_once 'components/navigation.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="header-content">
                    <h1>Explore Cars</h1>
                    <p>Discover our extensive collection of Japanese performance cars.</p>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Car ....">
                    <button class="filter-btn"><i class="fas fa-sliders-h"></i></button>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="filters">
                <span class="filter-label">Filter by:</span>
                <button class="filter-btn active">
                    <i class="fas fa-border-all"></i> All
                </button>
                <button class="filter-btn">
                    <i class="fas fa-tachometer-alt"></i> Performance
                </button>
                <button class="filter-btn">
                    <i class="fas fa-car-side"></i> Drift
                </button>
                <button class="filter-btn">
                    <i class="fas fa-clock"></i> Classic
                </button>
                <button class="filter-btn">
                    <i class="fas fa-car"></i> Modern
                </button>
                <button class="filter-btn">
                    <i class="fas fa-flag-checkered"></i> JDM
                </button>
            </div>

            <div class="car-grid">
                <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <a href="car_detail.php?id=<?php echo $car['id']; ?>" class="car-link">
                        <div class="car-image-container">
                            <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="car-image" />
                        </div>
                        <div class="car-details">
                            <span class="car-category"><?php echo htmlspecialchars($car['category']); ?></span>
                            <h3 class="car-title"><?php echo htmlspecialchars($car['name']); ?></h3>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <span><?php echo htmlspecialchars($car['rating']); ?> / 5.0</span>
                            </div>
                            <div class="car-features">
                                <?php foreach ($car['features'] as $feature): ?>
                                <span class="feature-tag">
                                    <i class="fas fa-check"></i>
                                    <?php echo htmlspecialchars($feature); ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                            <div class="car-specs">
                                <?php foreach ($car['specs'] as $key => $value): ?>
                                <div class="spec-item">
                                    <div class="spec-label"><?php echo ucfirst(htmlspecialchars($key)); ?></div>
                                    <div class="spec-value"><?php echo htmlspecialchars($value); ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </a>
                    <div class="car-footer">
                        <div class="price"><?php echo htmlspecialchars($car['price']); ?></div>
                        <div class="actions">
                            <button class="save-btn <?php echo in_array($car['id'], $savedCars) ? 'saved' : ''; ?>" 
                                    onclick="toggleSave(this, <?php echo $car['id']; ?>)">
                                <i class="<?php echo in_array($car['id'], $savedCars) ? 'fas' : 'far'; ?> fa-heart"></i>
                            </button>
                            <button class="rent-btn" onclick="addToCart(this, <?php echo $car['id']; ?>)">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Rent now</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
        function toggleSave(btn, carId) {
            const icon = btn.querySelector('i');
            const isSaved = icon.classList.contains('fas');
            
            // Toggle icon immediately for responsiveness
            icon.classList.toggle('fas');
            icon.classList.toggle('far');
            btn.classList.toggle('saved');

            // Send AJAX request to update saved cars
            fetch('save_car.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}&action=${isSaved ? 'remove' : 'add'}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert UI changes on failure
                    icon.classList.toggle('fas');
                    icon.classList.toggle('far');
                    btn.classList.toggle('saved');
                    alert('Failed to update saved cars: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(() => {
                // Revert UI changes on network error
                icon.classList.toggle('fas');
                icon.classList.toggle('far');
                btn.classList.toggle('saved');
                alert('Network error: Failed to update saved cars.');
            });
        }

        function addToCart(btn, carId) {
            btn.disabled = true;
            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}&action=add`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check"></i> Added to cart';
                    btn.style.background = '#28a745';
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-shopping-cart"></i> Rent now';
                        btn.disabled = false;
                        btn.style.background = '#1a1a1a';
                    }, 2000);
                } else {
                    alert('Failed to add to cart: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                }
            })
            .catch(() => {
                alert('Network error: Failed to add to cart.');
                btn.disabled = false;
            });
        }

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const category = btn.textContent.trim();
                document.querySelectorAll('.car-card').forEach(card => {
                    const cardCategory = card.querySelector('.car-category').textContent;
                    if (category === 'All' || category === cardCategory) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>

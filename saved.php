<?php
session_start();
require_once 'config/database.php';

$userId = 1; // Default user ID since we don't have authentication yet

try {
    // Get saved cars with their details and features
    $query = "
        SELECT c.*, GROUP_CONCAT(cf.feature) as features
        FROM saved_cars sc
        JOIN cars c ON sc.car_id = c.id
        LEFT JOIN car_features cf ON c.id = cf.car_id
        WHERE sc.user_id = :user_id
        GROUP BY c.id
    ";
    $stmt = $db->prepare($query);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $db->lastErrorMsg());
    }
    
    $stmt->bindValue(':user_id', $userId);
    $result = $stmt->execute();
    if (!$result) {
        throw new Exception("Failed to execute statement: " . $db->lastErrorMsg());
    }
    
    $savedCars = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $row['features'] = $row['features'] ? explode(',', $row['features']) : [];
        $row['specs'] = [
            'engine' => $row['engine'],
            'power' => $row['power'],
            'transmission' => $row['transmission']
        ];
        $savedCars[] = $row;
    }
} catch(Exception $e) {
    error_log("Error fetching saved cars in saved.php: " . $e->getMessage());
    die("<p>Sorry, an error occurred while loading your saved cars. Please try again later.</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Cars - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            margin: 2rem;
            border: 1px solid #eee;
        }

        .empty-state i {
            font-size: 4rem;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            opacity: 0.2;
        }

        .empty-state h2 {
            color: #1a1a1a;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .empty-state p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.5;
        }

        .explore-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.2rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .explore-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .saved-grid {
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

        .saved-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid #eee;
        }

        .saved-card:hover {
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

        .saved-card:hover .car-image {
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

        .remove-btn {
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

        .remove-btn:hover {
            background: #dc3545;
            border-color: #dc3545;
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
                    <h1>Saved Cars</h1>
                    <p>Your collection of favorite Japanese cars.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <?php if (empty($savedCars)): ?>
            <div class="empty-state">
                <i class="far fa-heart"></i>
                <h2>No Saved Cars</h2>
                <p>Start exploring our collection and save your favorite cars!</p>
                <a href="explore.php" class="explore-btn">
                    <i class="fas fa-compass"></i>
                    Explore Cars
                </a>
            </div>
            <?php else: ?>
            <div class="saved-grid">
                <?php foreach ($savedCars as $car): ?>
                <div class="saved-card">
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
                        </div>
                    </a>
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
                    <div class="car-footer">
                        <div class="price"><?php echo htmlspecialchars($car['price']); ?></div>
                        <div class="actions">
                            <button class="remove-btn" onclick="removeCar(this, <?php echo $car['id']; ?>)">
                                <i class="fas fa-times"></i>
                            </button>
                            <button class="rent-btn">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Rent now</span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function removeCar(btn, carId) {
            btn.disabled = true;
            // Send AJAX request to remove car
            fetch('save_car.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}&action=remove`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the car card from DOM with fade out
                    const card = btn.closest('.saved-card');
                    card.style.transition = 'opacity 0.5s ease';
                    card.style.opacity = '0';
                    setTimeout(() => card.remove(), 500);
                    
                    // Show empty state if no cars left
                    if (document.querySelectorAll('.saved-card').length === 1) {
                        const emptyState = `
                            <div class="empty-state">
                                <i class="far fa-heart"></i>
                                <h2>No Saved Cars</h2>
                                <p>Start exploring our collection and save your favorite cars!</p>
                                <a href="explore.php" class="explore-btn">
                                    <i class="fas fa-compass"></i>
                                    Explore Cars
                                </a>
                            </div>
                        `;
                        document.querySelector('.saved-grid').outerHTML = emptyState;
                    }
                } else {
                    alert('Failed to remove saved car: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                }
            })
            .catch(() => {
                alert('Network error: Failed to remove saved car.');
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>

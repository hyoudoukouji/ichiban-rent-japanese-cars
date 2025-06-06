<?php
session_start();
require_once 'config/database.php';

// Get cars in cart (from session for now)
$cartItems = isset($_SESSION['cart_items']) ? $_SESSION['cart_items'] : [];
$rentedCars = [];

if (!empty($cartItems)) {
    try {
        $placeholders = str_repeat('?,', count($cartItems) - 1) . '?';
        $query = "
            SELECT c.*, GROUP_CONCAT(cf.feature) as features
            FROM cars c
            LEFT JOIN car_features cf ON c.id = cf.car_id
            WHERE c.id IN ($placeholders)
            GROUP BY c.id
        ";
        
        $stmt = $db->prepare($query);
        $i = 1;
        foreach ($cartItems as $carId) {
            $stmt->bindValue($i++, $carId);
        }
        
        $result = $stmt->execute();
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $row['features'] = $row['features'] ? explode(',', $row['features']) : [];
            $rentedCars[] = $row;
        }
    } catch(Exception $e) {
        error_log("Error fetching cart items: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Cars - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cart-empty {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            margin: 2rem;
        }

        .cart-empty i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .cart-empty h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .cart-empty p {
            color: #666;
            margin-bottom: 2rem;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .cart-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
        }

        .remove-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #dc3545;
            color: white;
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .car-info h3 {
            margin: 0 0 0.5rem;
            font-size: 1.25rem;
        }

        .car-price {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 1.1rem;
            margin: 1rem 0;
        }

        .checkout-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem;
        }

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            opacity: 0.9;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .total-label {
            font-size: 1.1rem;
            color: #666;
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 600;
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
                    <h1>Rent Cars</h1>
                    <p>Review and complete your car rental.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <?php if (empty($rentedCars)): ?>
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <h2>Your Cart is Empty</h2>
                <p>Start exploring our collection and add cars to rent!</p>
                <a href="explore.php" class="explore-btn">
                    <i class="fas fa-compass"></i>
                    Explore Cars
                </a>
            </div>
            <?php else: ?>
            <div class="cart-grid">
                <?php foreach ($rentedCars as $car): ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" class="car-image">
                    <button class="remove-btn" onclick="removeFromCart(this, <?php echo $car['id']; ?>)">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="car-info">
                        <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                        <div class="car-price"><?php echo htmlspecialchars($car['price']); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="checkout-section">
                <div class="total-section">
                    <span class="total-label">Total Amount</span>
                    <span class="total-amount">Rp <?php 
                        $total = array_sum(array_map(function($car) {
                            return (int)str_replace(['Rp ', '.', ','], '', $car['price']);
                        }, $rentedCars));
                        echo number_format($total, 0, ',', '.');
                    ?></span>
                </div>
                <button class="checkout-btn" onclick="checkout()">
                    Proceed to Checkout
                </button>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function removeFromCart(btn, carId) {
            btn.disabled = true;
            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `car_id=${carId}&action=remove`
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = btn.closest('.cart-item');
                    item.style.transition = 'opacity 0.5s ease';
                    item.style.opacity = '0';
                    setTimeout(() => item.remove(), 500);
                    
                    // Show empty state if no items left
                    if (document.querySelectorAll('.cart-item').length === 1) {
                        const emptyState = `
                            <div class="cart-empty">
                                <i class="fas fa-shopping-cart"></i>
                                <h2>Your Cart is Empty</h2>
                                <p>Start exploring our collection and add cars to rent!</p>
                                <a href="explore.php" class="explore-btn">
                                    <i class="fas fa-compass"></i>
                                    Explore Cars
                                </a>
                            </div>
                        `;
                        document.querySelector('.cart-grid').outerHTML = emptyState;
                        document.querySelector('.checkout-section').remove();
                    }
                } else {
                    alert('Failed to remove item from cart: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                }
            })
            .catch(() => {
                alert('Network error: Failed to remove item from cart.');
                btn.disabled = false;
            });
        }

        function checkout() {
            // Basic modal implementation for checkout
            const modalHtml = `
                <div id="checkout-modal" style="position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); display:flex; justify-content:center; align-items:center; z-index:1000;">
                    <div style="background:white; padding:2rem; border-radius:12px; max-width:400px; width:90%; text-align:center;">
                        <h2>Checkout</h2>
                        <p>This is a demo checkout. Payment integration will be implemented soon.</p>
                        <button id="close-checkout" style="margin-top:1rem; padding:0.5rem 1rem; background:#1a1a1a; color:white; border:none; border-radius:8px; cursor:pointer;">Close</button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            document.getElementById('close-checkout').addEventListener('click', () => {
                document.getElementById('checkout-modal').remove();
            });
        }
    </script>
</body>
</html>

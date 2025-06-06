<?php
session_start();
require_once 'config/database.php';

// Simulated rental history (replace with actual data from database)
$rentals = [
    [
        'id' => 'RNT001',
        'car_name' => 'Toyota Supra MK4',
        'start_date' => '2024-05-01',
        'end_date' => '2024-05-03',
        'price' => 'Rp 9.890.000',
        'status' => 'Completed'
    ],
    [
        'id' => 'RNT002',
        'car_name' => 'Nissan GT-R R35',
        'start_date' => '2024-04-15',
        'end_date' => '2024-04-17',
        'price' => 'Rp 12.500.000',
        'status' => 'Completed'
    ],
    [
        'id' => 'RNT003',
        'car_name' => 'Honda NSX Type-R',
        'start_date' => '2024-06-01',
        'end_date' => '2024-06-03',
        'price' => 'Rp 7.890.000',
        'status' => 'Upcoming'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .history-content {
            padding: 2rem;
        }

        .history-filters {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 20px;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #1a1a1a;
            color: white;
            border-color: #1a1a1a;
        }

        .rental-grid {
            display: grid;
            gap: 1.5rem;
        }

        .rental-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 2rem;
        }

        .rental-icon {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #1a1a1a;
        }

        .rental-info h3 {
            margin: 0 0 0.5rem;
            font-size: 1.1rem;
        }

        .rental-dates {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .rental-id {
            color: #666;
            font-size: 0.9rem;
        }

        .rental-price {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 1.1rem;
            text-align: right;
        }

        .rental-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: inline-block;
        }

        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-upcoming {
            background: #e3f2fd;
            color: #1976d2;
        }

        .empty-history {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
        }

        .empty-history i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .empty-history h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .empty-history p {
            color: #666;
            margin-bottom: 2rem;
        }

        .explore-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .explore-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
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
                    <h1>Purchase History</h1>
                    <p>View your rental history and upcoming bookings.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="history-content">
                <div class="history-filters">
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Completed</button>
                    <button class="filter-btn">Upcoming</button>
                    <button class="filter-btn">Cancelled</button>
                </div>

                <?php if (empty($rentals)): ?>
                <div class="empty-history">
                    <i class="fas fa-history"></i>
                    <h2>No Rental History</h2>
                    <p>You haven't rented any cars yet. Start exploring our collection!</p>
                    <a href="explore.php" class="explore-btn">
                        <i class="fas fa-compass"></i>
                        Explore Cars
                    </a>
                </div>
                <?php else: ?>
                <div class="rental-grid">
                    <?php foreach ($rentals as $rental): ?>
                    <div class="rental-card">
                        <div class="rental-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="rental-info">
                            <h3><?php echo htmlspecialchars($rental['car_name']); ?></h3>
                            <div class="rental-dates">
                                <?php echo date('M d, Y', strtotime($rental['start_date'])); ?> - 
                                <?php echo date('M d, Y', strtotime($rental['end_date'])); ?>
                            </div>
                            <div class="rental-id">Order ID: <?php echo htmlspecialchars($rental['id']); ?></div>
                        </div>
                        <div class="rental-details">
                            <div class="rental-price"><?php echo htmlspecialchars($rental['price']); ?></div>
                            <div class="rental-status status-<?php echo strtolower($rental['status']); ?>">
                                <?php echo htmlspecialchars($rental['status']); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                // Implement actual filtering logic here
            });
        });
    </script>
</body>
</html>

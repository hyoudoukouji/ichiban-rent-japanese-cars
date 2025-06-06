<?php
session_start();
require_once 'config/database.php';
require_once 'api/auth/functions.php';

$currentUser = getCurrentUser();
if (!$currentUser) {
    header('Location: /index.php');
    exit;
}

try {
    // Fetch user data from database
    $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->bindValue(':id', $currentUser['id'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if (!$user) {
        throw new Exception('User not found');
    }

    try {
        // Get total rentals
        $stmt = $db->prepare('SELECT COUNT(*) as total FROM rentals WHERE user_id = :id');
        $stmt->bindValue(':id', $currentUser['id'], SQLITE3_INTEGER);
        $result = $stmt->execute();
        $rentals = $result->fetchArray(SQLITE3_ASSOC);
        $user['total_rentals'] = $rentals ? $rentals['total'] : 0;
    } catch (Exception $e) {
        // If rentals table doesn't exist or other error
        $user['total_rentals'] = 0;
    }

    // Decode preferred cars JSON
    $user['preferred_cars'] = isset($user['preferred_cars']) ? json_decode($user['preferred_cars'], true) : [];

} catch (Exception $e) {
    error_log("Error fetching user data: " . $e->getMessage());
    $user = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-email {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #666;
        }

        .profile-details {
            background: white;
            border-radius: 12px;
            padding: 2rem;
        }

        .details-section {
            margin-bottom: 2rem;
        }

        .details-section h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #1a1a1a;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .detail-item {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .detail-label {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #1a1a1a;
        }

        .preferences {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .preference-tag {
            background: #1a1a1a;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }

        .edit-btn {
            background: #1a1a1a;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .edit-btn:hover {
            opacity: 0.9;
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
                    <h1>Profile</h1>
                    <p>Manage your personal information and preferences.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="profile-content">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-avatar">
                        <?php echo isset($user['name']) ? substr($user['name'], 0, 1) : ''; ?>
                    </div>
                    <h2 class="profile-name"><?php echo isset($user['name']) ? htmlspecialchars($user['name']) : 'N/A'; ?></h2>
                    <p class="profile-email"><?php echo isset($user['email']) ? htmlspecialchars($user['email']) : 'N/A'; ?></p>
                    
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo isset($user['total_rentals']) ? $user['total_rentals'] : 0; ?></div>
                            <div class="stat-label">Total Rentals</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo isset($user['preferred_cars']) ? count($user['preferred_cars']) : 0; ?></div>
                            <div class="stat-label">Preferences</div>
                        </div>
                    </div>

                    <button class="edit-btn">Edit Profile</button>
                </div>

                <!-- Profile Details -->
                <div class="profile-details">
                    <div class="details-section">
                        <h2>Personal Information</h2>
                        <div class="details-grid">
                            <div class="detail-item">
                                <div class="detail-label">Phone Number</div>
                            <div class="detail-value"><?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : 'N/A'; ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Address</div>
                                <div class="detail-value"><?php echo isset($user['address']) ? htmlspecialchars($user['address']) : 'N/A'; ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Member Since</div>
                                <div class="detail-value"><?php echo isset($user['joined_date']) ? date('F Y', strtotime($user['joined_date'])) : 'N/A'; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="details-section">
                        <h2>Car Preferences</h2>
                        <div class="preferences">
                            <?php if (isset($user['preferred_cars']) && is_array($user['preferred_cars'])): ?>
                                <?php foreach ($user['preferred_cars'] as $preference): ?>
                                    <span class="preference-tag"><?php echo htmlspecialchars($preference); ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="preference-tag">No preferences set</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="auth-modal">
        <div class="auth-content">
            <div class="auth-header">
                <h2>Edit Profile</h2>
                <button class="close-btn" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editProfileForm" class="auth-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Car Preferences</label>
                    <div class="preferences-select">
                        <label><input type="checkbox" name="preferred_cars[]" value="Performance" <?php echo isset($user['preferred_cars']) && in_array('Performance', $user['preferred_cars']) ? 'checked' : ''; ?>> Performance</label>
                        <label><input type="checkbox" name="preferred_cars[]" value="JDM" <?php echo isset($user['preferred_cars']) && in_array('JDM', $user['preferred_cars']) ? 'checked' : ''; ?>> JDM</label>
                        <label><input type="checkbox" name="preferred_cars[]" value="Luxury" <?php echo isset($user['preferred_cars']) && in_array('Luxury', $user['preferred_cars']) ? 'checked' : ''; ?>> Luxury</label>
                        <label><input type="checkbox" name="preferred_cars[]" value="Classic" <?php echo isset($user['preferred_cars']) && in_array('Classic', $user['preferred_cars']) ? 'checked' : ''; ?>> Classic</label>
                    </div>
                </div>
                <button type="submit" class="auth-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <style>
        .preferences-select {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .preferences-select label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .preferences-select input[type="checkbox"] {
            width: auto;
        }
    </style>

    <script>
        function openEditModal() {
            document.getElementById('editProfileModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editProfileModal').style.display = 'none';
        }

        document.querySelector('.edit-btn').addEventListener('click', openEditModal);

        document.getElementById('editProfileForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                preferred_cars: Array.from(formData.getAll('preferred_cars[]'))
            };

            try {
                const response = await fetch('/api/profile/update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('Profile updated successfully!');
                    window.location.reload();
                } else {
                    alert(result.error || 'Failed to update profile');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to update profile');
            }
        });
    </script>
</body>
</html>

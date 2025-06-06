<?php
session_start();
require_once 'config/database.php';

// Simulated user settings (replace with actual data from database)
$settings = [
    'notifications' => [
        'email' => true,
        'push' => true,
        'sms' => false
    ],
    'privacy' => [
        'profile_visible' => true,
        'rental_history_visible' => false
    ],
    'preferences' => [
        'language' => 'English',
        'currency' => 'IDR',
        'theme' => 'Light'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Ichiban Rent</title>
    <link rel="icon" href="https://i.imgur.com/Xva9t0J.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-content {
            padding: 2rem;
        }

        .settings-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .settings-section h2 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-info {
            flex: 1;
        }

        .setting-label {
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
        }

        .setting-description {
            font-size: 0.875rem;
            color: #666;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #1a1a1a;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }

        .setting-select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: white;
            min-width: 150px;
        }

        .save-btn {
            background: #1a1a1a;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }

        .save-btn:hover {
            opacity: 0.9;
        }

        .settings-footer {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
            text-align: right;
        }

        .danger-zone {
            background: #fff5f5;
        }

        .danger-zone h2 {
            color: #dc3545;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
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
                    <h1>Settings</h1>
                    <p>Manage your account settings and preferences.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="settings-content">
                <!-- Notifications Settings -->
                <div class="settings-section">
                    <h2>Notifications</h2>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Email Notifications</div>
                            <div class="setting-description">Receive updates about your rentals via email</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" <?php echo $settings['notifications']['email'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Push Notifications</div>
                            <div class="setting-description">Get instant updates in your browser</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" <?php echo $settings['notifications']['push'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">SMS Notifications</div>
                            <div class="setting-description">Receive updates via text message</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" <?php echo $settings['notifications']['sms'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="settings-section">
                    <h2>Privacy</h2>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Profile Visibility</div>
                            <div class="setting-description">Make your profile visible to other users</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" <?php echo $settings['privacy']['profile_visible'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Rental History Privacy</div>
                            <div class="setting-description">Show your rental history to other users</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" <?php echo $settings['privacy']['rental_history_visible'] ? 'checked' : ''; ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="settings-section">
                    <h2>Preferences</h2>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Language</div>
                            <div class="setting-description">Choose your preferred language</div>
                        </div>
                        <select class="setting-select">
                            <option value="en" <?php echo $settings['preferences']['language'] === 'English' ? 'selected' : ''; ?>>English</option>
                            <option value="id">Bahasa Indonesia</option>
                            <option value="jp">日本語</option>
                        </select>
                    </div>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Currency</div>
                            <div class="setting-description">Select your preferred currency</div>
                        </div>
                        <select class="setting-select">
                            <option value="idr" <?php echo $settings['preferences']['currency'] === 'IDR' ? 'selected' : ''; ?>>IDR</option>
                            <option value="usd">USD</option>
                            <option value="jpy">JPY</option>
                        </select>
                    </div>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Theme</div>
                            <div class="setting-description">Choose your preferred theme</div>
                        </div>
                        <select class="setting-select">
                            <option value="light" <?php echo $settings['preferences']['theme'] === 'Light' ? 'selected' : ''; ?>>Light</option>
                            <option value="dark">Dark</option>
                            <option value="system">System</option>
                        </select>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="settings-section danger-zone">
                    <h2>Danger Zone</h2>
                    <div class="setting-item">
                        <div class="setting-info">
                            <div class="setting-label">Delete Account</div>
                            <div class="setting-description">Permanently delete your account and all data</div>
                        </div>
                        <button class="delete-btn" onclick="confirmDelete()">Delete Account</button>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="settings-footer">
                    <button class="save-btn" onclick="saveSettings()">Save Changes</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        function saveSettings() {
            const saveBtn = document.querySelector('.save-btn');
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            // Gather settings data
            const data = {
                notifications: {
                    email: document.querySelector('input[type="checkbox"]:nth-of-type(1)').checked,
                    push: document.querySelector('input[type="checkbox"]:nth-of-type(2)').checked,
                    sms: document.querySelector('input[type="checkbox"]:nth-of-type(3)').checked,
                },
                privacy: {
                    profile_visible: document.querySelector('input[type="checkbox"]:nth-of-type(4)').checked,
                    rental_history_visible: document.querySelector('input[type="checkbox"]:nth-of-type(5)').checked,
                },
                preferences: {
                    language: document.querySelectorAll('.setting-select')[0].value,
                    currency: document.querySelectorAll('.setting-select')[1].value,
                    theme: document.querySelectorAll('.setting-select')[2].value,
                }
            };

            fetch('save_settings.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Settings saved successfully!');
                } else {
                    alert('Failed to save settings: ' + (data.error || 'Unknown error'));
                }
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save Changes';
            })
            .catch(() => {
                alert('Network error: Failed to save settings.');
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save Changes';
            });
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                fetch('delete_account.php', {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Account deleted successfully. Redirecting to homepage.');
                        window.location.href = 'index.php';
                    } else {
                        alert('Failed to delete account: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(() => {
                    alert('Network error: Failed to delete account.');
                });
            }
        }
    </script>
</body>
</html>

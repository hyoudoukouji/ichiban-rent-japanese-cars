<?php
require_once __DIR__ . '/../api/auth/functions.php';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$user = getCurrentUser();

// Navigation items with their icons and URLs
$nav_items = [
    'index' => ['Home', 'fa-home'],
    'explore' => ['Explore', 'fa-compass']
];

// Add authenticated-only menu items
if ($user) {
    $nav_items = array_merge($nav_items, [
        'saved' => ['Saved', 'fa-heart'],
        'rent' => ['Rent', 'fa-car'],
        'history' => ['Purchase History', 'fa-history'],
        'profile' => ['Profile', 'fa-user'],
        'settings' => ['Settings', 'fa-cog']
    ]);
}

// Add terms at the end for all users
$nav_items['terms'] = ['Terms & Conditions', 'fa-file-contract'];
?>
<aside class="sidebar">
    <div class="logo">
        <img src="https://i.imgur.com/Xva9t0J.png?v=2" alt="User Logo" class="logo-img" onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg width=40 height=40 xmlns=http://www.w3.org/2000/svg%3E%3Crect width=40 height=40 fill=%231a1a1a/%3E%3Ctext x=20 y=25 font-family=Arial font-size=16 fill=white text-anchor=middle%3EIC%3C/text%3E%3C/svg%3E';" />
        <span>Ichiban Rent</span>
    </div>
    <nav>
        <ul>
            <?php foreach ($nav_items as $page => $item): ?>
                <li class="<?= $current_page === $page ? 'active' : '' ?>">
                    <a href="<?= $page === 'index' ? '/index.php' : $page.'.php' ?>">
                        <i class="fas <?= $item[1] ?>"></i> <?= $item[0] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php if ($user): ?>
    <div class="user-info">
        <div class="user-avatar"><i class="fas fa-user"></i></div>
        <div class="user-details">
            <span class="username"><?= htmlspecialchars($user['username']) ?></span>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>
    </div>
    <?php endif; ?>
</aside>

<style>
.user-info {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 1rem;
    border-top: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 1rem;
}

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
}

.user-details {
    flex: 1;
}

.username {
    display: block;
    font-weight: 500;
    margin-bottom: 0.3rem;
}

.logout-btn {
    background: none;
    border: none;
    color: #666;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 0;
}

.logout-btn:hover {
    color: var(--primary-color);
}
</style>

<script>
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        fetch('/api/auth/logout.php')
            .then(() => window.location.reload());
    }
}
</script>

<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<div id="authModal" class="auth-modal">
    <div class="auth-content">
        <div class="auth-header">
            <h2 id="authTitle">Login</h2>
            <button class="close-btn">&times;</button>
        </div>
        
        <div id="authMessage" class="auth-message"></div>
        <!-- Login Form -->
        <form id="loginForm" class="auth-form" novalidate>
            <div class="form-group">
                <label for="loginEmail">Email</label>
                <input type="email" id="loginEmail" name="email" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="auth-btn">Login</button>
            <p class="auth-switch">Don't have an account? <a href="#" id="showRegister">Register</a></p>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="auth-form" novalidate>
            <div class="form-group">
                <label for="registerUsername">Username</label>
                <input type="text" id="registerUsername" name="username" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="registerEmail">Email</label>
                <input type="email" id="registerEmail" name="email" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="registerPassword">Password</label>
                <input type="password" id="registerPassword" name="password" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" required autocomplete="new-password">
            </div>
            <button type="submit" class="auth-btn">Register</button>
            <p class="auth-switch">Already have an account? <a href="#" id="showLogin">Login</a></p>
        </form>
    </div>
</div>

<style>
.auth-message {
    margin-bottom: 1rem;
    padding: 0.75rem;
    border-radius: var(--border-radius);
    display: none;
}

.auth-message.error {
    display: block;
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.auth-message.success {
    display: block;
    background: #dcfce7;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

.auth-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.auth-content {
    background: white;
    padding: 2rem;
    border-radius: var(--border-radius);
    width: 100%;
    max-width: 400px;
    position: relative;
}

.auth-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.auth-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    color: #666;
}

.auth-form {
    display: none;
}

#loginForm {
    display: block;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    font-size: 1rem;
}

.auth-btn {
    width: 100%;
    padding: 0.75rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    margin-top: 1rem;
}

.auth-btn:hover {
    opacity: 0.9;
}

.auth-switch {
    text-align: center;
    margin-top: 1rem;
    color: #666;
}

.auth-switch a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.auth-switch a:hover {
    text-decoration: underline;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const authModal = document.getElementById('authModal');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const authTitle = document.getElementById('authTitle');
    const profileBtn = document.querySelector('.profile-btn');
    const closeBtn = document.querySelector('.close-btn');
    
    // Show modal when profile button is clicked (only if user is not authenticated)
    fetch('/api/auth/check.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                profileBtn.addEventListener('click', () => {
                    authModal.style.display = 'flex';
                });
            }
        })
        .catch(console.error);

    // Close modal when close button is clicked
    closeBtn.addEventListener('click', () => {
        authModal.style.display = 'none';
    });

    // Close modal when clicking outside
    authModal.addEventListener('click', (e) => {
        if (e.target === authModal) {
            authModal.style.display = 'none';
        }
    });

    // Switch between login and register forms
    document.getElementById('showRegister').addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        authTitle.textContent = 'Register';
    });

    document.getElementById('showLogin').addEventListener('click', (e) => {
        e.preventDefault();
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
        authTitle.textContent = 'Login';
    });

    const authMessage = document.getElementById('authMessage');

    function showMessage(message, type = 'error') {
        authMessage.textContent = message;
        authMessage.className = `auth-message ${type}`;
        setTimeout(() => {
            authMessage.style.display = 'none';
            authMessage.className = 'auth-message';
        }, 5000);
    }

    // Handle login form submission
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);
        
        try {
            const response = await fetch('/api/auth/login.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok) {
                showMessage('Login successful! Redirecting...', 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showMessage(data.message || 'Login failed');
            }
        } catch (error) {
            showMessage('An error occurred. Please try again.');
        }
    });

    // Handle register form submission
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(registerForm);
        
        if (formData.get('password') !== formData.get('confirm_password')) {
            showMessage('Passwords do not match');
            return;
        }
        
        try {
            const response = await fetch('/api/auth/register.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok) {
                showMessage('Registration successful! Please login.', 'success');
                setTimeout(() => {
                    registerForm.style.display = 'none';
                    loginForm.style.display = 'block';
                    authTitle.textContent = 'Login';
                    authMessage.style.display = 'none';
                }, 1000);
            } else {
                showMessage(data.message || 'Registration failed');
            }
        } catch (error) {
            showMessage('An error occurred. Please try again.');
        }
    });
});
</script>

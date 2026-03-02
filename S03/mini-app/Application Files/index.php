<?php
/**
 * Home Page
 * Welcome page for all users
 */

require_once 'functions.php';

$is_logged_in = isLoggedIn();
$username = $_SESSION['username'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Mini App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">
                <i class="fa-solid fa-user-circle"></i>
                Mini App
            </a>
            <div class="navbar-actions">
                <?php if ($is_logged_in): ?>
                    <a href="profile.php" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-user"></i> Profile
                    </a>
                    <a href="logout.php" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-sign-out-alt"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-sign-in-alt"></i> Login
                    </a>
                    <a href="register.php" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-user-plus"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <!-- Hero Section -->
            <div style="text-align: center; color: white; margin: 4rem 0;">
                <h1 style="font-size: 3rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-user-circle" style="font-size: 3.5rem;"></i>
                    Mini App
                </h1>
                <p style="font-size: 1.3rem; margin-bottom: 2rem; opacity: 0.9;">
                    User Profile Management System
                </p>

                <?php if ($is_logged_in): ?>
                    <div class="alert alert-success" style="max-width: 500px; margin: 2rem auto; background: rgba(16, 185, 129, 0.2); border-left: 4px solid #10b981; color: white;">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <strong>Welcome back, <?php echo escapeHTML($username); ?>!</strong><br>
                            You are logged in. Visit your <a href="profile.php" style="color: white; font-weight: 600; text-decoration: underline;">profile page</a> to manage your account.
                        </div>
                    </div>
                <?php else: ?>
                    <p style="font-size: 1rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                        Create an account to manage your profile, upload an avatar, and add a bio. Our secure system uses industry-standard encryption to protect your data.
                    </p>
                    
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="register.php" class="btn btn-primary" style="font-size: 1.05rem; padding: 1rem 2rem;">
                            <i class="fa-solid fa-user-plus"></i> Create Account
                        </a>
                        <a href="login.php" class="btn btn-secondary" style="font-size: 1.05rem; padding: 1rem 2rem; background: white; color: #667eea;">
                            <i class="fa-solid fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Features Section -->
            <div style="margin-top: 4rem; margin-bottom: 4rem;">
                <h2 style="text-align: center; color: white; font-size: 2rem; margin-bottom: 3rem;">
                    <i class="fa-solid fa-star"></i> Features
                </h2>

                <div class="grid grid-cols-2">
                    <!-- Feature 1 -->
                    <div class="card">
                        <div style="padding: 2rem; text-align: center;">
                            <i class="fa-solid fa-user-shield" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 0.75rem;">Secure Registration</h3>
                            <p style="color: var(--gray-600);">
                                Create an account with strong password encryption and email validation.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="card">
                        <div style="padding: 2rem; text-align: center;">
                            <i class="fa-solid fa-lock" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 0.75rem;">Advanced Security</h3>
                            <p style="color: var(--gray-600);">
                                Brute-force protection, XSS prevention, and SQL injection mitigation.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="card">
                        <div style="padding: 2rem; text-align: center;">
                            <i class="fa-solid fa-image" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 0.75rem;">Avatar Upload</h3>
                            <p style="color: var(--gray-600);">
                                Upload and manage your profile picture with file type validation.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="card">
                        <div style="padding: 2rem; text-align: center;">
                            <i class="fa-solid fa-pen-fancy" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 0.75rem;">Profile Management</h3>
                            <p style="color: var(--gray-600);">
                                Edit your bio and personal information anytime from your profile.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="card">
                        <div style="padding: 2rem; text-align: center;">
                            <i class="fa-solid fa-database" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 0.75rem;">Data Persistence</h3>
                            <p style="color: var(--gray-600);">
                                Your information is securely stored in our database with proper backups.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 6 -->
                    <div class="card">
                        <div style="padding: 2rem; text-align: center;">
                            <i class="fa-solid fa-mobile-screen" style="font-size: 2.5rem; color: #667eea; margin-bottom: 1rem;"></i>
                            <h3 style="margin-bottom: 0.75rem;">Responsive Design</h3>
                            <p style="color: var(--gray-600);">
                                Works seamlessly on desktop, tablet, and mobile devices.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tech Stack -->
            <div style="background: white; border-radius: 1rem; padding: 2rem; margin-bottom: 4rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                <h3 style="text-align: center; margin-bottom: 2rem;">
                    <i class="fa-solid fa-code"></i> Technology Stack
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; text-align: center;">
                    <div>
                        <p style="font-weight: 600; color: var(--primary); margin-bottom: 0.25rem;">Backend</p>
                        <p style="color: var(--gray-600);">PHP 7.4+</p>
                    </div>
                    <div>
                        <p style="font-weight: 600; color: var(--primary); margin-bottom: 0.25rem;">Database</p>
                        <p style="color: var(--gray-600);">MySQL / MariaDB</p>
                    </div>
                    <div>
                        <p style="font-weight: 600; color: var(--primary); margin-bottom: 0.25rem;">Frontend</p>
                        <p style="color: var(--gray-600);">HTML5 + CSS3</p>
                    </div>
                    <div>
                        <p style="font-weight: 600; color: var(--primary); margin-bottom: 0.25rem;">Security</p>
                        <p style="color: var(--gray-600);">Bcrypt + Prepared Statements</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Mini App. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
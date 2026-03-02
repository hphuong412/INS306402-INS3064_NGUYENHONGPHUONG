<?php
/**
 * User Login Page
 * Authentication with brute force protection
 */

require_once 'functions.php';

// Redirect if already logged in
redirectIfLoggedIn();

$error = '';
$username_input = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Check if username is provided
    if (empty($username)) {
        $error = 'Please enter your username';
    } elseif (empty($password)) {
        $error = 'Please enter your password';
    } else {
        // Check brute force protection
        if (checkLoginAttempts($username)) {
            $error = '❌ Too many login attempts. Please try again after 15 minutes.';
        } else {
            // Get user from database
            $sql = "SELECT id, password FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Verify password
                if (verifyPassword($password, $user['password'])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $username;
                    
                    // Record successful attempt
                    recordLoginAttempt($username, true);
                    
                    // Redirect to profile
                    header('Location: ' . BASE_URL . 'profile.php');
                    exit();
                } else {
                    // Wrong password
                    recordLoginAttempt($username, false);
                    $error = '❌ Invalid password. Please try again.';
                    $username_input = escapeHTML($username);
                }
            } else {
                // User not found
                recordLoginAttempt($username, false);
                $error = '❌ Username not found.';
                $username_input = escapeHTML($username);
            }
            
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mini App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Animated Shooting Stars Background -->
    <div class="night-bg" aria-hidden="true">
        <div class="night">
            <span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span>
            <span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span>
            <span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span>
            <span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span>
            <span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span><span class="shooting_star"></span>
        </div>
    </div>

    <nav class="navbar"></nav>
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">
                <i class="fa-solid fa-user-circle"></i>
                Mini App
            </a>
            <div class="navbar-actions">
                <a href="register.php" class="btn btn-primary btn-sm">Register</a>
            </div>
        </div>
    </nav>

    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <i class="fa-solid fa-sign-in-alt" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h1>Welcome Back</h1>
                <p>Login to your account</p>
            </div>

            <div class="auth-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <div><?php echo $error; ?></div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="form">
                    <div class="form-group">
                        <label for="username">
                            <i class="fa-solid fa-user"></i> Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            value="<?php echo $username_input; ?>"
                            placeholder="Enter your username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fa-solid fa-lock"></i> Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa-solid fa-sign-in-alt"></i> Login
                    </button>
                </form>

                <div class="mt-3" style="text-align: center; padding: 1rem; background: var(--gray-50); border-radius: 0.5rem;">
                    <p style="font-size: 0.85rem; color: var(--gray-600); margin: 0;">
                        <strong>Demo Account:</strong><br>
                        Username: <code style="background: white; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">demouser</code><br>
                        Password: <code style="background: white; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">Demo123</code>
                    </p>
                </div>
            </div>

            <div class="auth-footer">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Mini App. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php
/**
 * User Registration Page
 * Form for new users to create an account
 */

require_once 'functions.php';

// Redirect if already logged in
redirectIfLoggedIn();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $username = sanitizeInput($_POST['username'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (!isValidUsername($username)) {
        $errors['username'] = 'Username must be 3-20 characters, alphanumeric and underscore only';
    } elseif (usernameExists($username)) {
        $errors['username'] = 'Username already exists';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!isValidEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    } elseif (emailExists($email)) {
        $errors['email'] = 'Email already registered';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    } elseif (!isStrongPassword($password)) {
        $errors['password'] = 'Password must contain uppercase, lowercase, and numbers';
    }
    
    if (empty($password_confirm)) {
        $errors['password_confirm'] = 'Please confirm your password';
    } elseif ($password !== $password_confirm) {
        $errors['password_confirm'] = 'Passwords do not match';
    }
    
    // If no errors, register user
    if (empty($errors)) {
        $hashed_password = hashPassword($password);
        
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $success = true;
            // Clear form
            $username = $email = $password = $password_confirm = '';
        } else {
            $errors['database'] = 'Registration failed. Please try again.';
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mini App</title>
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
                <a href="login.php" class="btn btn-primary btn-sm">Login</a>
            </div>
        </div>
    </nav>

    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <i class="fa-solid fa-user-plus" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h1>Create Account</h1>
                <p>Join our community today</p>
            </div>

            <div class="auth-body">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <strong>Registration successful!</strong><br>
                            Your account has been created. You can now <a href="login.php" style="color: inherit; font-weight: 600;">login</a>.
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors) && !$success): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <div>
                            <strong>Registration failed!</strong>
                            Please fix the errors below.
                        </div>
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
                            value="<?php echo escapeHTML($username ?? ''); ?>"
                            placeholder="3-20 characters, alphanumeric"
                            required
                        >
                        <?php if (!empty($errors['username'])): ?>
                            <div class="form-error">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <?php echo $errors['username']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fa-solid fa-envelope"></i> Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo escapeHTML($email ?? ''); ?>"
                            placeholder="example@domain.com"
                            required
                        >
                        <?php if (!empty($errors['email'])): ?>
                            <div class="form-error">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <?php echo $errors['email']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fa-solid fa-lock"></i> Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="At least 8 characters"
                            required
                        >
                        <div class="form-help">
                            <i class="fa-solid fa-info-circle"></i>
                            Must contain: uppercase, lowercase, numbers
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <div class="form-error">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <?php echo $errors['password']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">
                            <i class="fa-solid fa-lock"></i> Confirm Password
                        </label>
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm" 
                            placeholder="Re-enter your password"
                            required
                        >
                        <?php if (!empty($errors['password_confirm'])): ?>
                            <div class="form-error">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <?php echo $errors['password_confirm']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa-solid fa-user-plus"></i> Create Account
                    </button>
                </form>
            </div>

            <div class="auth-footer">
                Already have an account? <a href="login.php">Login here</a>
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
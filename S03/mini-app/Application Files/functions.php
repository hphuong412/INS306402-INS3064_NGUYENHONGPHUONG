<?php
/**
 * Security & Utility Functions
 * Reusable functions for security, validation, and data handling
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

// ============================================
// SECURITY FUNCTIONS
// ============================================

/**
 * Hash password using bcrypt
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password against hash
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Escape HTML to prevent XSS attacks
 */
function escapeHTML($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize user input
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current logged-in user
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return $_SESSION['user_id'];
}

/**
 * Redirect to login if not authenticated
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'login.php');
        exit();
    }
}

/**
 * Redirect to home if already logged in
 */
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: ' . BASE_URL . 'profile.php');
        exit();
    }
}

/**
 * Get user IP address
 */
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * Check login attempts (brute force protection)
 */
function checkLoginAttempts($username) {
    global $conn;
    
    $ip = getUserIP();
    $time_limit = strtotime('-15 minutes');
    
    $sql = "SELECT COUNT(*) as attempts FROM login_attempts 
            WHERE username = ? AND ip_address = ? AND attempt_time > FROM_UNIXTIME(?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $username, $ip, $time_limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['attempts'] >= 5; // Allow 5 attempts
}

/**
 * Record login attempt
 */
function recordLoginAttempt($username, $success = false) {
    global $conn;
    
    $ip = getUserIP();
    
    $sql = "INSERT INTO login_attempts (username, ip_address, success) 
            VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $username, $ip, $success);
    $stmt->execute();
    $stmt->close();
}

// ============================================
// VALIDATION FUNCTIONS
// ============================================

/**
 * Validate email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate username (alphanumeric and underscore, 3-20 chars)
 */
function isValidUsername($username) {
    return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username) === 1;
}

/**
 * Validate password strength
 */
function isStrongPassword($password) {
    // At least 8 characters, 1 uppercase, 1 lowercase, 1 number
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/', $password) === 1;
}

/**
 * Validate file upload - Image only
 */
function isValidImage($file) {
    if (!isset($file) || $file['error'] !== 0) {
        return false;
    }
    
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    // Check MIME type
    if (!in_array($file['type'], $allowed)) {
        return false;
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        return false;
    }
    
    // Check actual file content using getimagesize
    if (@getimagesize($file['tmp_name']) === false) {
        return false;
    }
    
    return true;
}

// ============================================
// FILE UPLOAD FUNCTIONS
// ============================================

/**
 * Upload avatar image and return filename
 */
function uploadAvatar($file, $user_id) {
    if (!isValidImage($file)) {
        return null;
    }
    
    // Create uploads directory if it doesn't exist
    $upload_dir = __DIR__ . '/uploads/avatars/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate unique filename
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'avatar_' . $user_id . '_' . time() . '.' . $ext;
    $filepath = $upload_dir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return 'uploads/avatars/' . $filename;
    }
    
    return null;
}

/**
 * Delete old avatar file
 */
function deleteAvatar($avatar_path) {
    if (empty($avatar_path)) {
        return;
    }
    
    $file_path = __DIR__ . '/' . $avatar_path;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// ============================================
// DATABASE FUNCTIONS
// ============================================

/**
 * Get user data by ID
 */
function getUserById($user_id) {
    global $conn;
    
    $sql = "SELECT id, username, email, bio, avatar, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

/**
 * Check if username exists
 */
function usernameExists($username) {
    global $conn;
    
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

/**
 * Check if email exists
 */
function emailExists($email) {
    global $conn;
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

// ============================================
// ALERT & MESSAGE FUNCTIONS
// ============================================

/**
 * Display alert message
 */
function displayAlert($type, $message) {
    $colors = [
        'success' => '#10b981',
        'error' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6'
    ];
    
    $color = $colors[$type] ?? '#3b82f6';
    
    echo <<<HTML
    <div class="alert alert-$type" role="alert">
        <div class="alert-icon">
            <i class="fa-solid fa-{$type}"></i>
        </div>
        <div class="alert-content">
            <p>$message</p>
        </div>
    </div>
    HTML;
}

?>
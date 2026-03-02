<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mini_app_db');

// Thay localhost bằng 127.0.0.1
// hoặc thêm socket

$conn = new mysqli(
    '127.0.0.1',      // Thay từ 'localhost'
    'root',
    '',
    'mini_app_db',
    3306,             // Port
    '/Applications/XAMPP/xamppfiles/mysql/run/mysqld.sock'  // Socket path
);

if ($conn->connect_error) {
    die("❌ Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

define('BASE_URL', 'http://localhost:8000/');
?>
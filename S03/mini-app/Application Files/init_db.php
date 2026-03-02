<?php
/**
 * Database Initialization Script
 * Creates all necessary tables for the application
 * Run this once to set up the database
 */

// Use direct connection to create database
$conn_init = new mysqli('localhost', 'root', '');

if ($conn_init->connect_error) {
    die("❌ Connection Failed: " . $conn_init->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS mini_app_db";
if ($conn_init->query($sql) === TRUE) {
    echo "✅ Database created successfully<br>";
} else {
    echo "❌ Error creating database: " . $conn_init->error . "<br>";
}

$conn_init->close();

// Now connect to the created database
$conn = new mysqli('localhost', 'root', '', 'mini_app_db');

if ($conn->connect_error) {
    die("❌ Connection Failed: " . $conn->connect_error);
}

// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    bio TEXT,
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email)
)";

if ($conn->query($sql_users) === TRUE) {
    echo "✅ Users table created successfully<br>";
} else {
    echo "❌ Error creating users table: " . $conn->error . "<br>";
}

// Create login_attempts table for security
$sql_attempts = "CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success BOOLEAN DEFAULT FALSE,
    INDEX idx_username (username),
    INDEX idx_ip (ip_address)
)";

if ($conn->query($sql_attempts) === TRUE) {
    echo "✅ Login attempts table created successfully<br>";
} else {
    echo "❌ Error creating login attempts table: " . $conn->error . "<br>";
}

echo "<br>✅ Database initialization completed!<br>";
echo "⚠️ You can delete this file after running it once.";

$conn->close();
?>
-- Use existing database or create one
CREATE DATABASE IF NOT EXISTS company_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE company_db;

-- Create employees table
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    department ENUM('hr', 'it', 'finance', 'marketing', 'operations') NOT NULL,
    hire_date DATE NOT NULL,
    salary DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
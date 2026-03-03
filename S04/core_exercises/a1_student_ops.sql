-- Create database
CREATE DATABASE IF NOT EXISTS student_management_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Use database
USE student_management_db;

-- Create table: classes
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    department VARCHAR(100)
) ENGINE=InnoDB;

-- Create table: students
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_code VARCHAR(50) UNIQUE,
    full_name VARCHAR(150),
    email VARCHAR(150) NOT NULL UNIQUE,
    age INT,
    class_id INT,
    CONSTRAINT fk_students_class
        FOREIGN KEY (class_id)
        REFERENCES classes(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;
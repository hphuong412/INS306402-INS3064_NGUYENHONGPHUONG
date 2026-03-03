-- Use existing database or create new one if needed
CREATE DATABASE IF NOT EXISTS library_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE library_db;

-- 1️⃣ Books table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(150) NOT NULL,
    isbn VARCHAR(17) NOT NULL UNIQUE, -- ISBN-13 stored as VARCHAR
    published_year YEAR,
    available_copies INT DEFAULT 1
) ENGINE=InnoDB;

-- 2️⃣ Members table
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE,
    phone VARCHAR(20), -- International format support
    membership_date DATE DEFAULT (CURRENT_DATE)
) ENGINE=InnoDB;

-- 3️⃣ Borrow Records table
CREATE TABLE IF NOT EXISTS borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,

    CONSTRAINT fk_borrow_book
        FOREIGN KEY (book_id)
        REFERENCES books(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_borrow_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;
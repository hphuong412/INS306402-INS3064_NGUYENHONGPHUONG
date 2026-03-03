-- Create database if needed
CREATE DATABASE IF NOT EXISTS event_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE event_db;

-- Create events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(200) NOT NULL,
    description TEXT,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    event_details JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_event_time CHECK (end_time > start_time)
) ENGINE=InnoDB;
INSERT INTO events (event_name, description, start_time, end_time, event_details)
VALUES (
    'Tech Conference 2026',
    'Annual technology event',
    '2026-06-10 09:00:00',
    '2026-06-10 17:00:00',
    JSON_OBJECT(
        'location', 'Hanoi',
        'ticket_price', 500000,
        'max_attendees', 300,
        'tags', JSON_ARRAY('tech', 'ai', 'networking')
    )
);
SELECT 
    event_name,
    event_details->>'$.location' AS location
FROM events;
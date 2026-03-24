<?php
// students/delete.php
// This script deletes a student by ID, then redirects back to the list.

// Include Database class
require_once __DIR__ . '/../classes/Database.php';

// Get ID from query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// If ID is invalid, just go back
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db = Database::getInstance();

    // Delete student with this ID
    // If there are enrollments, they will be deleted automatically (ON DELETE CASCADE)
    $db->delete('students', 'id = ?', [$id]);
} catch (Exception $e) {
    // Optionally log or show a message
    // error_log('Delete student failed: ' . $e->getMessage());
}

// Redirect to list with deleted flag
header('Location: index.php?deleted=1');
exit;
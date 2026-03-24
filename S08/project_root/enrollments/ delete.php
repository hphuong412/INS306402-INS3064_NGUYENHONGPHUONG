
<?php
// enrollments/delete.php
// Deletes an enrollment record by ID.

require_once __DIR__ . '/../classes/Database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db = Database::getInstance();
    $db->delete('enrollments', 'id = ?', [$id]);
} catch (Exception $e) {
    // Could log the error here
    // error_log('Delete enrollment failed: ' . $e->getMessage());
}

header('Location: index.php?deleted=1');
exit;
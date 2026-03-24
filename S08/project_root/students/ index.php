
<?php
// students/index.php
// This page shows a table of all students with links to create, edit, and delete.

// Include the Database class
require_once __DIR__ . '/../classes/Database.php';

// Get the shared Database instance
$db = Database::getInstance();

// Fetch all students from the database, newest first
$students = $db->fetchAll('SELECT * FROM students ORDER BY created_at DESC');

// Read simple success messages from query string (optional UX)
$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = 'Student created successfully.';
} elseif (isset($_GET['updated'])) {
    $successMessage = 'Student updated successfully.';
} elseif (isset($_GET['deleted'])) {
    $successMessage = 'Student deleted successfully.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #4CAF50; color: #fff; }
        .btn { padding: 4px 8px; text-decoration: none; border-radius: 3px; }
        .btn-add { background: #4CAF50; color: #fff; }
        .btn-edit { background: #2196F3; color: #fff; }
        .btn-delete { background: #f44336; color: #fff; }
    </style>
</head>
<body>
<h1>Student Management</h1>

<?php if ($successMessage): ?>
    <!-- Show success message if available -->
    <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<p>
    <!-- Link to create a new student -->
    <a href="create.php" class="btn btn-add">+ Add Student</a>
</p>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($students as $student): ?>
        <tr>
            <!-- Directly show numeric ID and timestamp -->
            <td><?= $student['id'] ?></td>
            <!-- Escape text to avoid XSS -->
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= $student['created_at'] ?></td>
            <td>
                <!-- Edit and delete links; id is passed via query string -->
                <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-edit">Edit</a>
                <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-delete"
                   onclick="return confirm('Are you sure you want to delete this student?');">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

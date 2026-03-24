<?php
// students/edit.php
// This page shows a form to edit an existing student and handles the update.

// Include Database class
require_once __DIR__ . '/../classes/Database.php';

// Get student ID from query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// If the ID is invalid, redirect back to list
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$db     = Database::getInstance();
$errors = [];

// 1. Fetch existing student data
try {
    $student = $db->fetch('SELECT * FROM students WHERE id = ?', [$id]);

    if (!$student) {
        // No student found with this ID
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    // In a real app you might show a nicer error page
    die('Cannot load student data.');
}

// Pre-fill form fields with current data
$name  = $student['name'];
$email = $student['email'];

// 2. If form submitted, validate and update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    if (empty($errors)) {
        try {
            // Check if email belongs to another student
            $existing = $db->fetch(
                'SELECT id FROM students WHERE email = ? AND id <> ?',
                [$email, $id]
            );

            if ($existing) {
                $errors['email'] = 'This email belongs to another student.';
            } else {
                // Update record in DB
                $db->update('students', [
                    'name'  => $name,
                    'email' => $email,
                ], 'id = ?', [$id]);

                // Redirect back to list with updated flag
                header('Location: index.php?updated=1');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'An error occurred while updating. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
</head>
<body>
<h1>Edit Student</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color: red;"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <?php if (!empty($errors['name'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>
    </div>

    <div>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
        <?php if (!empty($errors['email'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['email']) ?></span>
        <?php endif; ?>
    </div>

    <button type="submit">Update</button>
    <a href="index.php">Cancel</a>
</form>

</body>
</html>
```


### 5.4 Delete student – `students/delete.php`

```php
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
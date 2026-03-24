<?php
// students/create.php
// This page shows a form to create a new student and handles the POST request.

// Include Database class
require_once __DIR__ . '/../classes/Database.php';

// Initialize variables for form fields and errors
$errors = [];
$name   = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Read form data, trim whitespace
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');

    // 2. Validate data
    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // 3. If no validation errors, try to insert into database
    if (empty($errors)) {
        try {
            $db = Database::getInstance();

            // Check if the email is already used by another student
            $existing = $db->fetch('SELECT id FROM students WHERE email = ?', [$email]);

            if ($existing) {
                // If there is already a student with this email, add error
                $errors['email'] = 'This email is already taken.';
            } else {
                // Insert new student record
                $db->insert('students', [
                    'name'  => $name,
                    'email' => $email,
                ]);

                // Redirect back to the list with a success flag
                header('Location: index.php?success=1');
                exit;
            }
        } catch (Exception $e) {
            // Generic error message displayed to the user
            // Detailed message was logged inside Database class
            $errors['general'] = 'An error occurred. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
</head>
<body>
<h1>Add New Student</h1>

<?php if (!empty($errors['general'])): ?>
    <!-- General error (e.g., DB connection issue) -->
    <p style="color: red;"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label>Name:</label><br>
        <!-- Keep old value after validation errors -->
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

    <button type="submit">Save</button>
    <a href="index.php">Cancel</a>
</form>

</body>
</html>

<?php
// enrollments/create.php
// This page lets the user pick one student and one course and creates an enrollment.

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Load students and courses for dropdowns
$students = $db->fetchAll('SELECT id, name FROM students ORDER BY name');
$courses  = $db->fetchAll('SELECT id, title FROM courses ORDER BY title');

$errors     = [];
$student_id = 0;
$course_id  = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read selected IDs from form
    $student_id = (int) ($_POST['student_id'] ?? 0);
    $course_id  = (int) ($_POST['course_id']  ?? 0);

    // Validate selection
    if ($student_id <= 0) {
        $errors['student_id'] = 'Please select a student.';
    }

    if ($course_id <= 0) {
        $errors['course_id'] = 'Please select a course.';
    }

    if (empty($errors)) {
        try {
            // Check for duplicate enrollment (student already enrolled in this course)
            $exists = $db->fetch(
                'SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?',
                [$student_id, $course_id]
            );

            if ($exists) {
                $errors['general'] = 'This student is already enrolled in this course.';
            } else {
                // Insert new enrollment
                $db->insert('enrollments', [
                    'student_id' => $student_id,
                    'course_id'  => $course_id,
                ]);

                header('Location: index.php?success=1');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'An error occurred. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Enrollment</title>
</head>
<body>
<h1>Add Enrollment</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color: red;"><?= htmlspecialchars($errors['general']) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label>Student:</label><br>
        <select name="student_id">
            <option value="0">-- Select student --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= $s['id'] ?>"
                    <?= ($s['id'] == $student_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['student_id'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['student_id']) ?></span>
        <?php endif; ?>
    </div>

    <div>
        <label>Course:</label><br>
        <select name="course_id">
            <option value="0">-- Select course --</option>
            <?php foreach ($courses as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= ($c['id'] == $course_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['course_id'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['course_id']) ?></span>
        <?php endif; ?>
    </div>

    <button type="submit">Save Enrollment</button>
    <a href="index.php">Cancel</a>
</form>

</body>
</html>

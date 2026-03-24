<?php
// enrollments/index.php
// This page shows all enrollments (student + course) using JOINs.

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Join enrollments with students and courses to display readable names
$sql = 'SELECT e.id,
               s.name  AS student_name,
               s.email,
               c.title AS course_title,
               e.enrolled_at
        FROM enrollments e
        JOIN students s ON e.student_id = s.id
        JOIN courses  c ON e.course_id  = c.id
        ORDER BY e.enrolled_at DESC';

$enrollments = $db->fetchAll($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrollments</title>
</head>
<body>
<h1>Enrollments</h1>

<p>
    <a href="create.php">+ Add Enrollment</a>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Student</th>
        <th>Email</th>
        <th>Course</th>
        <th>Enrolled At</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($enrollments as $enroll): ?>
        <tr>
            <td><?= $enroll['id'] ?></td>
            <td><?= htmlspecialchars($enroll['student_name']) ?></td>
            <td><?= htmlspecialchars($enroll['email']) ?></td>
            <td><?= htmlspecialchars($enroll['course_title']) ?></td>
            <td><?= $enroll['enrolled_at'] ?></td>
            <td>
                <a href="delete.php?id=<?= $enroll['id'] ?>"
                   onclick="return confirm('Cancel this enrollment?');">
                    Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();
$courses = $db->fetchAll('SELECT * FROM courses ORDER BY created_at DESC');
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Courses</title></head>
<body>

<h1>Courses</h1>
<a href="create.php">+ Add Course</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php foreach ($courses as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= htmlspecialchars($c['title']) ?></td>
    <td><?= htmlspecialchars($c['description']) ?></td>
    <td>
        <a href="edit.php?id=<?= $c['id'] ?>">Edit</a>
        <a href="delete.php?id=<?= $c['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
</body>
</html>
<?php
require_once __DIR__ . '/../classes/Database.php';

$id = (int)$_GET['id'];
$db = Database::getInstance();

$course = $db->fetch('SELECT * FROM courses WHERE id=?', [$id]);

$title = $course['title'];
$description = $course['description'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title === '') {
        $errors['title'] = 'Required';
    }

    if (empty($errors)) {
        $db->update('courses', [
            'title' => $title,
            'description' => $description
        ], 'id=?', [$id]);

        header('Location: index.php');
        exit;
    }
}
?>
<form method="post">
    Title: <input name="title" value="<?= htmlspecialchars($title) ?>"><br>
    <?= $errors['title'] ?? '' ?><br>

    Description:<br>
    <textarea name="description"><?= htmlspecialchars($description) ?></textarea><br>

    <button>Update</button>
</form>
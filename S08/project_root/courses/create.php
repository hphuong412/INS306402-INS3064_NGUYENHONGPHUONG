<?php
require_once __DIR__ . '/../classes/Database.php';

$title = '';
$description = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title === '') {
        $errors['title'] = 'Title is required';
    } elseif (strlen($title) < 3) {
        $errors['title'] = 'Min 3 characters';
    }

    if (empty($errors)) {
        $db = Database::getInstance();
        $db->insert('courses', [
            'title' => $title,
            'description' => $description
        ]);

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

    <button>Save</button>
</form>
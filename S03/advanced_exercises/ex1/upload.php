<?php
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['avatar'])) {
        $errors[] = "No file uploaded.";
    } else {

        if ($_FILES['avatar']['error'] !== 0) {
            $errors[] = "Upload error.";
        }

        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = mime_content_type($_FILES['avatar']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG and PNG allowed.";
        }

        if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            $errors[] = "Max size is 2MB.";
        }

        if (empty($errors)) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $ext;
            $destination = "uploads/" . $newName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                $success = "Upload successful!";
            } else {
                $errors[] = "Failed to move file.";
            }
        }
    }
}
?>

<h2>Upload Avatar</h2>

<?php if (!empty($errors)): ?>
<div style="color:red;">
    <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
</div>
<?php endif; ?>

<?php if ($success): ?>
<p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="avatar" required>
    <button type="submit">Upload</button>
</form>
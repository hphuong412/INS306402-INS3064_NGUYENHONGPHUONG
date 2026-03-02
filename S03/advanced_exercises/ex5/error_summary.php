<?php
$errors = [];
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($name)) {
        $errors['name'] = "Name required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email.";
    }
}
?>

<style>
.error { border: 2px solid red; }
.alert { background: #f8d7da; padding: 10px; }
</style>

<h2>Error Summary</h2>

<?php if (!empty($errors)): ?>
<div class="alert">
    <ul>
        <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name" 
           class="<?= isset($errors['name']) ? 'error' : '' ?>"
           value="<?= htmlspecialchars($name) ?>">
    <br><br>

    <input type="text" name="email"
           class="<?= isset($errors['email']) ? 'error' : '' ?>"
           value="<?= htmlspecialchars($email) ?>">
    <br><br>

    <button type="submit">Submit</button>
</form>
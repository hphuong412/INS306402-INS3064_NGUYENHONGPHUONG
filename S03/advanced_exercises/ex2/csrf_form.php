<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || 
        $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("403 Forbidden");
    }

    echo "Form submitted safely!";
}
?>

<h2>CSRF Protection</h2>

<form method="POST">
    <input type="hidden" name="csrf_token" 
           value="<?= $_SESSION['csrf_token'] ?>">
    <input type="text" name="name" required>
    <button type="submit">Submit</button>
</form>
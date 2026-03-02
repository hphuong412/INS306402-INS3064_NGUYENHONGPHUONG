<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $errors[] = "Username must be alphanumeric only.";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password missing uppercase.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password missing lowercase.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password missing number.";
    }
    if (!preg_match('/[\W]/', $password)) {
        $errors[] = "Password missing symbol.";
    }

    if (empty($errors)) {
        echo "Registration successful!";
    }
}
?>

<h2>Register</h2>

<?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
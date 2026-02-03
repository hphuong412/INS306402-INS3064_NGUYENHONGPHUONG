<?php
session_start();

/* Hardcoded credentials */
$correctUser = "admin";
$correctPass = "123456";

/* Initialize failed attempts */
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $correctUser && $password === $correctPass) {
        $message = "<p style='color:green'>Login Successful</p>";
        $_SESSION['failed_attempts'] = 0; // reset counter on success
    } else {
        $_SESSION['failed_attempts']++;
        $message = "<p style='color:red'>Invalid Credentials</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Login</title>
</head>
<body>

<h2>Login</h2>

<form method="post" action="">
    <label>Username:</label><br>
    <input type="text" name="username"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>

<br>

<?php
echo $message;

if ($_SESSION['failed_attempts'] > 0) {
    echo "<p>Failed Attempts: " . $_SESSION['failed_attempts'] . "</p>";
}
?>

</body>
</html>

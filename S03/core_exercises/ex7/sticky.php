<?php
$name = $email = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $pass  = $_POST["password"];

    if (strlen($pass) < 8) {
        $error = "Password too short!";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Register</h2>

<form method="post">
    Name: <input type="text" name="name" value="<?= $name ?>"><br><br>

    Email: <input type="email" name="email" value="<?= $email ?>"><br><br>

    Password: <input type="password" name="password"><br><br>

    <button type="submit">Submit</button>
</form>

<?php if ($error): ?>
<p style="color:red"><?= $error ?></p>
<?php endif; ?>

</body>
</html>

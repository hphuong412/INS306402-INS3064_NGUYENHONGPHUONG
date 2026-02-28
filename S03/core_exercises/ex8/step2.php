<?php
$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bio"])) {

    $bio = $_POST["bio"];
    $location = $_POST["location"];

    echo "<h2>FINAL RESULT</h2>";
    echo "Username: $username <br>";
    echo "Password: $password <br>";
    echo "Bio: $bio <br>";
    echo "Location: $location <br>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Step 2 – Profile Info</h2>

<form method="post">

    <input type="hidden" name="username" value="<?= $username ?>">
    <input type="hidden" name="password" value="<?= $password ?>">

    Bio: <textarea name="bio"></textarea><br><br>
    Location: <input type="text" name="location"><br><br>

    <button type="submit">Finish</button>
</form>

</body>
</html>

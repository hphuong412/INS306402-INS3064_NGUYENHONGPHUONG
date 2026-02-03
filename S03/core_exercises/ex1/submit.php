<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Result</title>
</head>
<body>

<?php
$fullname = $_POST['fullname'] ?? '';
$email    = $_POST['email'] ?? '';
$phone    = $_POST['phone'] ?? '';
$message  = $_POST['message'] ?? '';

if (empty($fullname) || empty($email) || empty($phone) || empty($message)) {
    echo "<h3 style='color:red'>Missing Data</h3>";
} else {
    echo "<h2>Submitted Information</h2>";
    echo "<ul>";
    echo "<li><strong>Full Name:</strong> $fullname</li>";
    echo "<li><strong>Email:</strong> $email</li>";
    echo "<li><strong>Phone Number:</strong> $phone</li>";
    echo "<li><strong>Message:</strong> $message</li>";
    echo "</ul>";
}
?>

</body>
</html>

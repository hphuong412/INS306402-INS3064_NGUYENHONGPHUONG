<?php
$result = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $op   = $_POST["operation"];

    // Validate numeric
    if (!is_numeric($num1) || !is_numeric($num2)) {
        $error = "Please enter valid numbers.";
    } else {
        switch ($op) {
            case "+":
                $calc = $num1 + $num2;
                break;
            case "-":
                $calc = $num1 - $num2;
                break;
            case "*":
                $calc = $num1 * $num2;
                break;
            case "/":
                if ($num2 == 0) {
                    $error = "Cannot divide by zero!";
                } else {
                    $calc = $num1 / $num2;
                }
                break;
            default:
                $error = "Invalid operation.";
        }

        if ($error == "") {
            $result = "$num1 $op $num2 = $calc";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Arithmetic Calculator</title>
</head>
<body>

<h2>Arithmetic Calculator</h2>

<form method="post">
    <input type="text" name="num1" required>

    <select name="operation">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>

    <input type="text" name="num2" required>

    <button type="submit">Calculate</button>
</form>

<?php
if ($error) {
    echo "<p style='color:red;'>$error</p>";
}

if ($result) {
    echo "<p><strong>$result</strong></p>";
}
?>

</body>
</html>

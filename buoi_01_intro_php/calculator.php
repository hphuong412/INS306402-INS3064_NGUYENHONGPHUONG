<?php
// Declare two numbers
$a = 20;
$b = 5;

// Calculations
$add = $a + $b;
$sub = $a - $b;
$mul = $a * $b;
$div = $b != 0 ? $a / $b : "Cannot divide by zero";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .box {
            width: 400px;
            margin: 80px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        p {
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Simple Calculator</h2>
    <p>Number A: <?php echo $a; ?></p>
    <p>Number B: <?php echo $b; ?></p>
    <hr>
    <p>Addition: <?php echo $add; ?></p>
    <p>Subtraction: <?php echo $sub; ?></p>
    <p>Multiplication: <?php echo $mul; ?></p>
    <p>Division: <?php echo $div; ?></p>
</div>

</body>
</html>

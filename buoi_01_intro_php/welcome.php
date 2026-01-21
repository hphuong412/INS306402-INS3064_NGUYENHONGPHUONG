<?php
// ===== Set timezone =====
date_default_timezone_set("Asia/Ho_Chi_Minh");

// Get current hour
$currentHour = date("H");

// ===== Greeting based on time =====
if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = "Good morning ☀️";
} elseif ($currentHour >= 12 && $currentHour < 18) {
    $greeting = "Good afternoon 🌤️";
} else {
    $greeting = "Good evening 🌙";
}

// ===== Day of the week (Vietnamese) =====
$daysOfWeek = [
    "Sunday"    => "Chủ Nhật",
    "Monday"    => "Thứ Hai",
    "Tuesday"   => "Thứ Ba",
    "Wednesday" => "Thứ Tư",
    "Thursday"  => "Thứ Năm",
    "Friday"    => "Thứ Sáu",
    "Saturday"  => "Thứ Bảy"
];

$todayEnglish  = date("l");
$todayVietnam  = $daysOfWeek[$todayEnglish];

// ===== Calculate remaining days in the month =====
$currentDay = date("d");
$totalDays  = date("t");

$daysRemaining = $totalDays - $currentDay;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Page</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #ffffff;
            width: 420px;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #444;
            margin: 10px 0;
        }

        .highlight {
            font-weight: bold;
            color: #0066cc;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2><?= $greeting ?></h2>

        <p>
            Today is:
            <span class="highlight"><?= $todayVietnam ?></span>
        </p>

        <p>
            Days remaining in this month:
            <span class="highlight"><?= $daysRemaining ?></span>
        </p>
    </div>

</body>
</html>

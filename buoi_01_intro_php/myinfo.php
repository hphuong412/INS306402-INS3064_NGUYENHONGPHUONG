<?php
$fullName    = "Nguyen Hong Phuong";
$dateOfBirth = "04/12/2005";
$hometown    = "Hung Yen";
$hobbies     = "Listening to music, watching movies, traveling";

$accessTime = date("d/m/Y - H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #ffe4ec;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 420px;
            background: #fff;
            padding: 30px;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(255, 105, 180, 0.35);
            text-align: center;
        }

        .kitty-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 4px solid #ff69b4;
            background: #ffe4ec;
            object-fit: cover;
        }

        h2 {
            color: #ff1493;
            margin-bottom: 22px;
        }

        .info-item {
            background: #ffe4ec;
            margin-bottom: 12px;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 15px;
            color: #444;
            text-align: left;
        }

        .info-item span {
            font-weight: 600;
            color: #d63384;
        }

        .access-time {
            margin-top: 18px;
            font-size: 13px;
            color: #aa4a6a;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="card">
        <!-- Hello Kitty Image -->
        <img src="hellokitty.png" alt="Hello Kitty" class="kitty-img">

        <h2>🎀 My Profile 🎀</h2>

        <div class="info-item">
            <span>Full Name:</span> <?= htmlspecialchars($fullName) ?>
        </div>

        <div class="info-item">
            <span>Date of Birth:</span> <?= htmlspecialchars($dateOfBirth) ?>
        </div>

        <div class="info-item">
            <span>Hometown:</span> <?= htmlspecialchars($hometown) ?>
        </div>

        <div class="info-item">
            <span>Hobbies:</span> <?= htmlspecialchars($hobbies) ?>
        </div>

        <div class="access-time">
            ⏰ Access Time: <?= $accessTime ?>
        </div>
    </div>

</body>
</html>

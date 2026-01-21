<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Profile - <?php echo "Nguyễn Hồng Phượng"; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
        }
        h1 { color: #333; margin-bottom: 5px; }
        .subtitle { color: #666; margin-bottom: 20px; }
        .info { text-align: left; }
        .info-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        .info-item:last-child { border-bottom: none; }
        .label { color: #888; }
        .value { color: #333; font-weight: 500; }
        .datetime {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="avatar">👤</div>
        
        <?php
        // Khai báo thông tin cá nhân
        $hoTen = "Nguyễn Hồng Phượng";
        $mssv = "23070452";
        $lop = "INS3064-02";
        $email = "23070452@vnu.edu.vn";
        ?>
        
        <h1><?php echo $hoTen; ?></h1>
        <p class="subtitle">Student <?php echo $lop; ?></p>
        
        <div class="info">
            <div class="info-item">
                <span class="label">📋 Student code:</span>
                <span class="value"><?php echo $mssv; ?></span>
            </div>
            <div class="info-item">
                <span class="label">📚 Class:</span>
                <span class="value"><?php echo $lop; ?></span>
            </div>
            <div class="info-item">
                <span class="label">📧 Email:</span>
                <span class="value"><?php echo $email; ?></span>
            </div>
        </div>
        
        <div class="datetime">
            <?php
            echo "🗓️ " . date("d/m/Y") . " | ";
            echo "⏰ " . date("H:i:s");
            ?>
        </div>
    </div>
</body>
</html>
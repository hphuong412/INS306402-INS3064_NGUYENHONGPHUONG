<?php
$height = 1.70;  // mét
$weight = 65;    // kg

// Tính BMI
$bmi = $weight / pow($height, 2);

// Đánh giá
if ($bmi < 18.5) {
    $status = "Gầy";
} elseif ($bmi < 25) {
    $status = "Bình thường";
} elseif ($bmi < 30) {
    $status = "Thừa cân";
} else {
    $status = "Béo phì";
}

// Hiển thị kết quả
echo "<h2>Kết quả BMI</h2>";
echo "Chiều cao: $height m <br>";
echo "Cân nặng: $weight kg <br>";
echo "BMI: " . round($bmi, 2) . "<br>";
echo "Đánh giá: <b>$status</b>";
?>

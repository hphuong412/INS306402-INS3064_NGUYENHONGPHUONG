<?php
function calculateBMI($kg, $m) {
    $bmi = $kg / ($m * $m);
    
    if ($bmi < 18.5) {
        $category = "Under";
    } elseif ($bmi >= 18.5 && $bmi < 25) {
        $category = "Normal";
    } else {
        $category = "Over";
    }
    
    return [
        'bmi' => round($bmi, 1),
        'category' => $category
    ];
}

// Example usage
$kg = 70;
$m = 1.75;
$result = calculateBMI($kg, $m);

echo "BMI: " . $result['bmi'] . " (" . $result['category'] . ")";
?>

<?php
function isPrime($n) {
    if ($n < 2) return false;

    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }
    return true;
}

echo "<h2>Các số nguyên tố từ 1 đến 100:</h2>";

for ($i = 1; $i <= 100; $i++) {
    if (isPrime($i)) {
        echo $i . " ";
    }
}
?>

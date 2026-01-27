<?php
$input = [1, 2, 3];
$reversed = [];

for ($i = count($input) - 1; $i >= 0; $i--) {
    $reversed[] = $input[$i];
}

echo "[" . implode(", ", $reversed) . "]";
?>

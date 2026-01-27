<?php
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        echo $i * $j . " ";
    }
    if ($i < 5) {
        echo "/ ";
    }
}
?>

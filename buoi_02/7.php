<?php
$int = 5;
$string = '5';

$loose = $int == $string;      // Loose comparison
$strict = $int === $string;    // Strict comparison

echo "Equal (" . ($loose ? "True" : "False") . "), Identical (" . ($strict ? "True" : "False") . ")";
?>

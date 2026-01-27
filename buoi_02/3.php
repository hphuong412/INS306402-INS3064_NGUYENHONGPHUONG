<?php
$string = '25.50';

$float = (float)$string;
$integer = (int)$float;

echo gettype($float) . "(" . $float . "), " . gettype($integer) . "(" . $integer . ")";
?>

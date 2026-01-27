<?php

function fmt(float $amt, string $c = '$'): string {
    return $c . number_format($amt, 2);
}

// Example usage
$input = fmt(50);
echo $input; // Output: "$50.00"

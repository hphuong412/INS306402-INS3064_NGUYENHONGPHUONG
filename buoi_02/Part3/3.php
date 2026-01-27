<?php

function isAdult(?int $age): bool {
    if ($age === null) {
        return false;
    }
    return $age >= 18;
}

// Example usage
$input = isAdult(null);
var_dump($input); // Output: False

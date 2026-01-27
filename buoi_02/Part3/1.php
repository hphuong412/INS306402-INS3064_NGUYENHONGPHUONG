<?php

function greet(string $name): string {
    return "Hello, $name!";
}

// Example usage
$input = greet("Sam");
echo $input; // Output: "Hello, Sam!"

<?php

function sanitize($data) {
    return htmlspecialchars(trim($data));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateLength($str, $min, $max) {
    $len = strlen($str);
    return ($len >= $min && $len <= $max);
}

function validatePassword($pass) {
    if (strlen($pass) < 8) return false;

    // must contain special char
    return preg_match("/[^a-zA-Z0-9]/", $pass);
}

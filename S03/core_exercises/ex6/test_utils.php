<?php
require "utils.php";

$tests = [
    "email" => ["test@gmail.com", "badmail@"],
    "password" => ["Abc@1234", "abc123"],
    "length" => ["hello", "hi"]
];

echo "<h2>UTIL TEST</h2>";

echo "<p>Email valid: ";
echo validateEmail($tests["email"][0]) ? "PASS" : "FAIL";
echo "</p>";

echo "<p>Email invalid: ";
echo !validateEmail($tests["email"][1]) ? "PASS" : "FAIL";
echo "</p>";

echo "<p>Password strong: ";
echo validatePassword($tests["password"][0]) ? "PASS" : "FAIL";
echo "</p>";

echo "<p>Password weak: ";
echo !validatePassword($tests["password"][1]) ? "PASS" : "FAIL";
echo "</p>";

echo "<p>Length test (hello 3–10): ";
echo validateLength("hello", 3, 10) ? "PASS" : "FAIL";
echo "</p>";

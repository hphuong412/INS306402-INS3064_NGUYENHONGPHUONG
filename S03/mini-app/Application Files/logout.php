<?php
/**
 * Logout Script
 * Destroy session and redirect to home
 */

require_once 'functions.php';

// Destroy session
session_destroy();

// Clear session variable
$_SESSION = [];

// Redirect to home
header('Location: ' . BASE_URL . 'index.php');
exit();
?>
<?php
$page = $_GET['page'] ?? 'home';

$allowed = ['home', 'contact'];

if (in_array($page, $allowed)) {
    include "pages/$page.php";
} else {
    echo "Page Not Found";
}
?>
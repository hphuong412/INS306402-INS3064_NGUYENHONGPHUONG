<?php
require_once __DIR__ . '/../classes/Database.php';

$id = (int)$_GET['id'];

$db = Database::getInstance();
$db->delete('courses', 'id=?', [$id]);

header('Location: index.php');
exit;
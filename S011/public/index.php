<?php
require_once __DIR__ . '/../controllers/BookController.php';

$controller = new BookController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
}
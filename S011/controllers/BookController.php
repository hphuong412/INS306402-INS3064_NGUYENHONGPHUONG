<?php
require_once __DIR__ . '/../models/BookModel.php';

class BookController {
    private $model;

    public function __construct() {
        $this->model = new BookModel();
    }

    public function index() {
        $books = $this->model->getAll();
        require __DIR__ . '/../views/books/index.php';
    }

    public function create() {
        require __DIR__ . '/../views/books/create.php';
    }

    public function store() {
        $title = $_POST['title'] ?? '';
        $this->model->create($title);
        header("Location: index.php");
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header("Location: index.php");
        exit;
    }
}
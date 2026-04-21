<?php
require_once __DIR__ . '/../config/database.php';

class BookModel {
    private PDO $db;

    public function __construct() {
        $this->db = getConnection();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title) {
        $stmt = $this->db->prepare("INSERT INTO books(title) VALUES(?)");
        return $stmt->execute([$title]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id=?");
        return $stmt->execute([$id]);
    }
}
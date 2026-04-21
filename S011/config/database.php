<?php
function getConnection(): PDO {
    $host = "localhost";
    $dbname = "tests";   // tên database bạn đã tạo
    $user = "root";
    $pass = "";         // XAMPP mặc định không có password

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $user,
            $pass
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {
        die("Lỗi kết nối DB: " . $e->getMessage());
    }
}
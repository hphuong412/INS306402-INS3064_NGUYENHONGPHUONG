
<!--BÀI TẬP 1: Sửa lỗi code -->
<!--Tìm và sửa lỗi trong đoạn code sau:-->

<!-- LỖIS TÌM THẤY: -->
<!-- 1. Dòng 1: echo "Hello World" thiếu dấu chấm phẩy (;) ở cuối -->
<!-- 2. Dòng 2: Cú pháp print sai - print không thể dùng dấu phẩy như echo -->
<!-- Cách sửa: dùng echo hoặc dùng toán tử . để nối chuỗi -->

<?php
// PHIÊN BẢN CÓ LỖI (Gốc):
// echo "Hello World"          // LỖI 1: Thiếu dấu ;
// echo "Welcome to PHP!";     
// print "This is", "PHP";     // LỖI 2: print không hỗ trợ multiple arguments với dấu phẩy

// PHIÊN BẢN SỬA LỖI:
echo "Hello World";            // Sửa: Thêm dấu ;
echo "Welcome to PHP!";        
echo "This is" . " PHP";       // Sửa: Dùng toán tử . để nối chuỗi
// Hoặc: print "This is PHP";
?>
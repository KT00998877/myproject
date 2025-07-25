<?php


namespace App\Controllers;

class CategoryController
{
    public function show($id)
    {
        // Kết nối DB
        $pdo = require __DIR__ . '/../config/db_connection.php';

        // Lấy tên thể loại
        $stmt = $pdo->prepare("SELECT ten_the_loai FROM the_loai WHERE ma_the_loai = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch();

        // Lấy sách thuộc thể loại
        $stmt = $pdo->prepare("SELECT * FROM sach WHERE ma_the_loai = ?");
        $stmt->execute([$id]);
        $books = $stmt->fetchAll();

        require_once BASE_VIEW_PATH . '/TheLoai.php';
    }
}

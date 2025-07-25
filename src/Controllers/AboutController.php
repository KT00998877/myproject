<?php
namespace App\Controllers;
use App\Models\Product;
use PDO;
class AboutController {
    private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $pdo = getDatabaseConnection();
        $productModel = new Product($pdo);
        $GTproducts = $productModel->getBooksByAuthor('Nguyễn Nhật Ánh');
        require_once __DIR__ . '/../view/gioithieu.php';
    }
}
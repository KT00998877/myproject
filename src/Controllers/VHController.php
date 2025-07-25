<?php
namespace App\Controllers;

use App\Models\Product;
use PDO;

class VHController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $pdo = getDatabaseConnection();
        $productModel = new Product($pdo);
        $products = $productModel->getProductsByCategory(2);
        require_once __DIR__ . '/../view/vanhoc.php';
    }
}
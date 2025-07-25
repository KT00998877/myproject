<?php 
namespace App\Controllers;
use App\Models\Product;
use PDO;

class KHController{
    private $pdo;
        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }
        public function index() {
            $pdo = getDatabaseConnection();
            $productModel = new Product($pdo);
            $KHproducts = $productModel->getProductsByCategory(3);
            require_once __DIR__ . ('/../view/khoahoc.php');
    }
}
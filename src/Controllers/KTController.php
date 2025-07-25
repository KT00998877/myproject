<?php 
namespace App\Controllers;
use App\Models\Product;
use PDO;

class KTController{
    private $pdo;
        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }
        public function index() {
            $pdo = getDatabaseConnection();
            $productModel = new Product($pdo);
            $KTproducts = $productModel->getProductsByCategory(1);
            require_once __DIR__ . ('/../view/kinhte.php');
    }
}
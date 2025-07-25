<?php 
namespace App\Controllers;

use App\Models\Product;
use PDO;

class NNController{

        private $pdo;

   public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function index(){
        $pdo = getDatabaseConnection();
        $productModel = new Product($pdo);
        $NNproducts = $productModel ->getProductsByCategory(6);
        require_once __DIR__ ."/../view/ngoaingu.php";
    }
}
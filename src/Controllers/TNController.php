<?php 
namespace App\Controllers;
use App\Models\Product;
use PDO;

class TNController{
    private $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function index(){
        $pdo= getDatabaseConnection();
        $productModel = new Product($pdo);
        $TNproducts = $productModel ->getProductsByCategory(4);
        require_once __DIR__ ."/../view/thieunhi.php";
}
}
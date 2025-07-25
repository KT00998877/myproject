<?php 
namespace App\Controllers;
use App\Models\Product;
use PDO;

class TLController{
    private $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function index(){
        $pdo= getDatabaseConnection();
        $productModel = new Product($pdo);
        $TLproducts = $productModel ->getProductsByCategory(5);
        require_once __DIR__ ."/../view/tamly.php";
}
}
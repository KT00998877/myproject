<?php
namespace App\Controllers;
use App\Models\Product;
use PDO;
class SMController {
   private $pdo;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
         $productModel = new Product($this->pdo);
        $fullproducts = $productModel->all();
       ;
        require_once BASE_VIEW_PATH . '/sachmoi.php';
        

}
}
<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\CartModel;

class CartController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function AddToCart()
    {
        session_start();
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            $_SESSION['notification'] = 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!';
            header('Location: /dangnhap');
            exit();
        }

        $ma_sach = $_POST['product_id'] ?? null;            // Đổi tên cho khớp CSDL
        $so_luong = max(1, intval($_POST['quantity'] ?? 1)); // Đổi tên cho khớp CSDL

        $productModel = new Product($this->pdo);
        $product = $productModel->find($ma_sach);

        if (!$product || $so_luong > $product->getStock_product()) {
            $_SESSION['notification'] = 'Số lượng sản phẩm không đủ trong kho!';
            header("Location: /cart");
            exit();
        }

        $cartModel = new CartModel($this->pdo);
        $ma_tai_khoan = $user['ma_tai_khoan'] ?? $user['id'] ?? null;

        if ($cartModel->addProductToCart($ma_tai_khoan, $ma_sach, $so_luong)) {
            $_SESSION['notification'] = 'Thêm vào giỏ hàng thành công!';
        } else {
            $_SESSION['notification'] = 'Không thể thêm vào giỏ hàng!';
        }

        header("Location: /cart");
        exit();
    }

    public function ViewCart()
    {
        session_start();
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            header('Location: /dangnhap');
            exit();
        }

        $ma_tai_khoan = $user['ma_tai_khoan'] ?? $user['id'] ?? null;
        $cartModel = new CartModel($this->pdo);
        $cartItems = $cartModel->getCartItemsByUserId($ma_tai_khoan);

        require_once BASE_VIEW_PATH . '/cart.php';
    }

    public function UpdateQuantity()
    {
        session_start();
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: /dangnhap');
            exit;
        }

        $ma_tai_khoan = $user['ma_tai_khoan'];
        $ma_sach = $_POST['ma_sach'] ?? null;
        $action = $_POST['action'] ?? null;

        $cartModel = new CartModel($this->pdo);
        $cart_id = $cartModel->findOrCreateCart($ma_tai_khoan);
        $cartModel->updateQuantity($cart_id, $ma_sach, $action);

        header('Location: /cart');
        exit;
    }


    public function removeItem()
    {
        session_start();
        $maTaiKhoan = $_SESSION['user']['ma_tai_khoan'];
        $maSach = $_POST['ma_sach'] ?? null;

        if ($maSach) {
            $model = new CartModel($this->pdo);
            $model->deleteItem($maTaiKhoan, $maSach);
        }

        header('Location: /cart');
        exit;
    }
}

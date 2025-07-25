<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function isAdmin()
    {
        session_start();
        $user = $_SESSION['user'] ?? null;

        // Giả định: vai_tro = 'admin' hoặc role = 'admin'
        return $user && ($user['vai_tro'] ?? $user['role'] ?? '') === 'quan_tri';
    }
    
    public function create()
{
    if (!$this->isAdmin()) {
        $_SESSION['notification'] = 'Bạn không có quyền truy cập chức năng này!';
        header('Location: /');
        exit();
    }

    $productModel = new Product($this->pdo);
    $categories = $productModel->getCategories();
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form
        $ten_sach = trim($_POST['ten_sach'] ?? '');
        $tac_gia = trim($_POST['tac_gia'] ?? '');
        $gia = floatval($_POST['gia'] ?? 0);
        $so_luong = intval($_POST['so_luong'] ?? 0);
        $ma_the_loai = $_POST['ma_the_loai'] ?? null;
        $duong_dan = null;

        // Validate thể loại
        if ($ma_the_loai === null || !is_numeric($ma_the_loai)) {
            $errors['ma_the_loai'] = 'Vui lòng chọn thể loại hợp lệ.';
        }

        // Xử lý upload hình ảnh nếu có
        if (!empty($_FILES['hinh_anh']['name'])) {
            $uploadDir = '/uploads/';
            $uploadPath = __DIR__ . '/../../public' . $uploadDir;

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $filename = uniqid() . '-' . basename($_FILES['hinh_anh']['name']);
            $targetFile = $uploadPath . $filename;

            if (move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $targetFile)) {
                $duong_dan = $uploadDir . $filename;
            }
        }

        // Nếu không có lỗi thì lưu vào DB
        if (empty($errors)) {
            $result = $productModel->createProduct($ten_sach, $tac_gia, $gia, $so_luong, $ma_the_loai,$duong_dan);

            $_SESSION['notification'] = $result ? 'Thêm sản phẩm thành công!' : 'Thêm sản phẩm thất bại!';
            header('Location: /sachmoi');
            exit();
        }

        // Nếu có lỗi, hiển thị lại form với dữ liệu cũ + lỗi
        require_once BASE_VIEW_PATH . '/create.php';
        return;
    }

    // Nếu là GET: hiển thị form rỗng
    require_once BASE_VIEW_PATH . '/create.php';
}



    public function edit($id)
    {
        if (!$this->isAdmin()) {
            $_SESSION['notification'] = 'Bạn không có quyền truy cập chức năng này!';
            header('Location: /');
            exit();
        }

        $productModel = new Product($this->pdo);
        $product = $productModel->find($id);

        if (!$product) {
            $_SESSION['notification'] = 'Không tìm thấy sản phẩm!';
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten_sach = $_POST['ten_sach'] ?? '';
            $tac_gia = $_POST['tac_gia'] ?? '';
            $gia = floatval($_POST['gia'] ?? 0);
            $so_luong = intval($_POST['so_luong'] ?? 0);

            $result = $productModel->updateProduct($id, $ten_sach, $tac_gia, $gia, $so_luong);

            $_SESSION['notification'] = $result ? 'Cập nhật thành công!' : 'Cập nhật thất bại!';
            header('Location: /');
            exit();
        }

        require_once BASE_VIEW_PATH . '/edit.php';
    }

    public function delete($id)
{
    if (!$this->isAdmin()) {
        $_SESSION['notification'] = 'Bạn không có quyền truy cập chức năng này!';
        header('Location: /');
        exit();
    }

    $productModel = new Product($this->pdo);
    $result = $productModel->deleteProduct($id);

    $_SESSION['notification'] = $result ? 'Xóa sản phẩm thành công!' : 'Xóa sản phẩm thất bại!';

    // 🔒 An toàn: Chỉ redirect nếu referer thuộc domain của bạn
    $referer = $_SERVER['HTTP_REFERER'] ?? null;
    $host = $_SERVER['HTTP_HOST'];

    if ($referer && strpos($referer, $host) !== false) {
        header("Location: $referer");
    } else {
        header("Location: /");
    }
    exit();
}



public function index()
{
    if (!$this->isAdmin()) {
        $_SESSION['notification'] = 'Bạn không có quyền truy cập chức năng này!';
        header('Location: /');
        exit();
    }

    $productModel = new Product($this->pdo);
    $fullproducts = $productModel->all();

    require_once BASE_VIEW_PATH . '/trangchu.php'; 
}
    public function sachMoi()
    {
        $productModel = new Product($this->pdo);
        $sachMoi = $productModel->getLatestBooks(); 
        require_once BASE_VIEW_PATH . '/sachmoi.php';
    }
    
}

<?php
namespace App\Controllers;

use App\Models\Product;

class LHController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        require_once __DIR__ . '/../view/lienhe.php';
    }

    public function handle()
{
    $errors = [];
    $ten = trim($_POST['ten'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $chu_de = trim($_POST['chu_de'] ?? '');
    $noi_dung = trim($_POST['noi_dung'] ?? '');
    // Kiểm tra CSRF token
    require_once __DIR__ . '/../helpers/csrf.php';
    if ($ten === '') {
        $errors['ten'] = 'Vui lòng nhập họ tên.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
    }
    if ($noi_dung === '') {
        $errors['noi_dung'] = 'Vui lòng nhập nội dung liên hệ.';
    }

    if (!empty($errors)) {
        require_once __DIR__ . '/../view/lienhe.php';
        return;
    }

    $lienHeModel = new Product($this->pdo); 
    $thanhCong = $lienHeModel->addContact($ten, $email, $chu_de, $noi_dung);

    if ($thanhCong === true) {
        $thongBao = 'Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất!';
    } else {
        $thongBao = 'Đã có lỗi xảy ra: ' . htmlspecialchars($thanhCong);
    }

    require_once __DIR__ . '/../view/lienhe.php';
}

}


<?php


namespace App\Controllers;

use PDO;

class DNController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $error = '';
        $username = '';
        require_once __DIR__ . '/../view/dangnhap.php';
    }

    public function handle()
    {
        session_start();
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $error = '';
        // Kiểm tra CSRF token
        require_once __DIR__ . '/../helpers/csrf.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!check_csrf_token($token)) {
                die('CSRF token không hợp lệ.');
            }
        if ($username === '' || $password === '') {
            $error = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
        } else {
            // Kiểm tra tài khoản trong database
            $stmt = $this->pdo->prepare("SELECT * FROM tai_khoan WHERE ten_dang_nhap = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['mat_khau'])) {
                $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            } else {
                // Lưu thông tin đăng nhập vào session
                $_SESSION['user'] = [
                    'ma_tai_khoan' => $user['ma_tai_khoan'],
                    'username' => $user['ten_dang_nhap'],
                    'role' => $user['vai_tro']
                ];
                // Phân quyền chuyển trang
                if ($user['vai_tro'] === 'quan_tri') {
                    header('Location: /');
                } else {
                    header('Location: /');
                }
                exit;
            }
        }
        // Trả về form nếu có lỗi
        require_once __DIR__ . '/../view/dangnhap.php';
    }
}
}
<?php

namespace App\Controllers;

class DKController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        $errors = [];
        $username = '';
        $email = '';
        $password = '';
        require_once __DIR__ . '/../view/dangky.php';
    }

    public function handle()
    {
        $errors = [];
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');
        // Kiểm tra CSRF token
        require_once __DIR__ . '/../helpers/csrf.php';
        if ($username === '') {
            $errors['username'] = 'Vui lòng nhập tên đăng nhập.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        }
        if ($password === '') {
            $errors['password'] = 'Vui lòng nhập mật khẩu.';
        }
        

        if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
        }


        // Kiểm tra trùng tên đăng nhập hoặc email
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tai_khoan WHERE ten_dang_nhap = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            $errors['username'] = 'Tên đăng nhập hoặc email đã tồn tại.';
        }

        if (!empty($errors)) {
            require_once __DIR__ . '/../view/dangky.php';
            return;
        }

        // Lưu vào database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO tai_khoan (ten_dang_nhap, email, mat_khau, vai_tro) VALUES (?, ?, ?, 'nguoi_dung')");
        $stmt->execute([$username, $email, $hashedPassword]);

        // Đăng ký xong chuyển về trang đăng nhập
        $_SESSION['success_message'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        header('Location: /dangnhap');
        exit;
    }
}

<?php

namespace App\Controllers;

use PDO;

class SanPhamController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function chiTiet($maSach)
    {
        $stmt = $this->pdo->prepare("
            SELECT sach.*, hinh_anh.duong_dan, nha_xuat_ban.ten_nxb
            FROM sach
            LEFT JOIN hinh_anh ON sach.ma_sach = hinh_anh.ma_sach
            LEFT JOIN nha_xuat_ban ON sach.ma_nxb = nha_xuat_ban.ma_nxb
            WHERE sach.ma_sach = :ma
            LIMIT 1
        ");
        $stmt->execute([':ma' => $maSach]);
        $sach = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sach) {
            $_SESSION['notification'] = 'Sách không tồn tại.';
            header('Location: /');
            exit;
        }

        require BASE_VIEW_PATH . '/chi_tiet_san_pham.php';
    }
}

<?php

namespace App\Controllers;

use PDO;

class TimKiemController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ✂️ Hàm bỏ dấu tiếng Việt
    private function boDau($str): string
    {
        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/[áàạảãâấầậẩẫăắằặẳẵ]/u', 'a', $str);
        $str = preg_replace('/[éèẹẻẽêếềệểễ]/u', 'e', $str);
        $str = preg_replace('/[íìịỉĩ]/u', 'i', $str);
        $str = preg_replace('/[óòọỏõôốồộổỗơớờợởỡ]/u', 'o', $str);
        $str = preg_replace('/[úùụủũưứừựửữ]/u', 'u', $str);
        $str = preg_replace('/[ýỳỵỷỹ]/u', 'y', $str);
        $str = preg_replace('/đ/u', 'd', $str);
        return $str;
    }

    public function tim()
    {
        $tuKhoa = $_GET['q'] ?? '';
        $tuKhoa = $this->boDau(trim($tuKhoa));

        // 🧠 Lấy toàn bộ sách
        $stmt = $this->pdo->query("
            SELECT sach.*, h.duong_dan
            FROM sach
            LEFT JOIN hinh_anh h ON sach.ma_sach = h.ma_sach
        ");
        $tatCa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 🎯 Lọc gần đúng theo tên sách không dấu
        $ketQua = array_filter($tatCa, function ($sach) use ($tuKhoa) {
            $ten = $this->boDau($sach['ten_sach'] ?? '');
            return strpos($ten, $tuKhoa) !== false;
        });

        require BASE_VIEW_PATH . '/tim_kiem.php';
    }
}

<?php

namespace App\Controllers;

use App\Models\CartModel;
use PDO;

class DH_Controller
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function xacNhanDatHang()
    {
        session_start();
        $userId = $_SESSION['user']['ma_tai_khoan'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $hoTen = trim($_POST['ho_ten'] ?? '');
        $sdt = trim($_POST['sdt'] ?? '');
        $diaChi = trim($_POST['dia_chi'] ?? '');
        $selected = $_POST['selected_items'] ?? [];

        if (empty($hoTen) || empty($sdt) || empty($diaChi) || empty($selected)) {
            echo "Thiếu thông tin, vui lòng kiểm tra lại.";
            return;
        }

        $cartModel = new CartModel($this->pdo);
        $cartItems = $cartModel->getCartItemsByUserId($userId);
        $selectedItems = array_filter($cartItems, fn($item) => in_array($item['ma_sach'], $selected));
        $tongTien = array_reduce($selectedItems, fn($sum, $item) => $sum + $item['so_luong'] * $item['gia'], 0);

        // Ghi vào bảng hoa_don kèm thông tin giao hàng
        $stmt = $this->pdo->prepare("
            INSERT INTO hoa_don (ma_tai_khoan, tong_tien, ngay_tao, ho_ten, sdt, dia_chi)
            VALUES (:ma, :tong, NOW(), :ten, :sdt, :diachi)
        ");
        $stmt->execute([
            ':ma'     => $userId,
            ':tong'   => $tongTien,
            ':ten'    => $hoTen,
            ':sdt'    => $sdt,
            ':diachi' => $diaChi
        ]);
        $maHoaDon = $this->pdo->lastInsertId();

        // Ghi chi tiết từng sách
        foreach ($selectedItems as $item) {
            $ct = $this->pdo->prepare("
                INSERT INTO chi_tiet_hoa_don (ma_hoa_don, ma_sach, so_luong, don_gia)
                VALUES (:hd, :sach, :sl, :gia)
            ");
            $ct->execute([
                ':hd'   => $maHoaDon,
                ':sach' => $item['ma_sach'],
                ':sl'   => $item['so_luong'],
                ':gia'  => $item['gia']
            ]);

            // Xóa khỏi giỏ hàng
            $cartModel->deleteItem($userId, $item['ma_sach']);
        }

        require BASE_VIEW_PATH . '/thong_bao_dat_hang.php';
    }
}

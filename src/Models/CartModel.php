<?php

namespace App\Models;

use PDO;

class CartModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Tìm cart đang xử lý, nếu chưa có thì tạo mới
    public function findOrCreateCart($user_id)
    {
        $sql = "SELECT id FROM cart WHERE ma_tai_khoan = :user_id AND status = 'Đang xử lý'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            return $cart['id'];
        } else {
            $sql = "INSERT INTO cart (ma_tai_khoan, status) VALUES (:user_id, 'Đang xử lý')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            return $this->db->lastInsertId();
        }
    }

    // Kiểm tra sản phẩm đã có trong cart chưa
    private function checkProductExistsInCart($cart_id, $ma_sach)
    {
        $sql = "SELECT COUNT(*) FROM cart_items WHERE cart_id = :cart_id AND ma_sach = :ma_sach";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'cart_id' => $cart_id,
            'ma_sach' => $ma_sach
        ]);
        return $stmt->fetchColumn() > 0;
    }

    // Cập nhật số lượng sản phẩm trong cart_items
    private function updateSoLuongInCartItems($cart_id, $ma_sach, $so_luong, $increase = false)
    {
        if ($increase) {
            $sql = "UPDATE cart_items SET so_luong = so_luong + :so_luong WHERE cart_id = :cart_id AND ma_sach = :ma_sach";
        } else {
            $sql = "UPDATE cart_items SET so_luong = :so_luong WHERE cart_id = :cart_id AND ma_sach = :ma_sach";
        }
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'so_luong' => $so_luong,
            'cart_id' => $cart_id,
            'ma_sach' => $ma_sach
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addProductToCart($user_id, $ma_sach, $so_luong)
    {
        $cart_id = $this->findOrCreateCart($user_id);

        if ($this->checkProductExistsInCart($cart_id, $ma_sach)) {
            return $this->updateSoLuongInCartItems($cart_id, $ma_sach, $so_luong, true);
        } else {
            $sql = "INSERT INTO cart_items (cart_id, ma_sach, so_luong) VALUES (:cart_id, :ma_sach, :so_luong)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'cart_id' => $cart_id,
                'ma_sach' => $ma_sach,
                'so_luong' => $so_luong
            ]);
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng của user
    public function getCartItemsByUserId($ma_tai_khoan)
    {
        $sql = "SELECT ci.*, s.ten_sach, s.gia, s.so_luong AS ton_kho
            FROM cart c
            JOIN cart_items ci ON c.id = ci.cart_id
            JOIN sach s ON ci.ma_sach = s.ma_sach
            WHERE c.ma_tai_khoan = :ma_tai_khoan AND c.status = 'Đang xử lý'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ma_tai_khoan' => $ma_tai_khoan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateQuantity($cart_id, $ma_sach, $action)
    {
        if ($action === 'increase') {
            $sql = "UPDATE cart_items SET so_luong = so_luong + 1 WHERE cart_id = :cart_id AND ma_sach = :ma_sach";
        } elseif ($action === 'decrease') {
            $sql = "UPDATE cart_items SET so_luong = GREATEST(1, so_luong - 1) WHERE cart_id = :cart_id AND ma_sach = :ma_sach";
        } else {
            return false;
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'cart_id' => $cart_id,
            'ma_sach' => $ma_sach
        ]);
    }

    public function deleteItem($maTaiKhoan, $maSach)
    {
        $cart_id = $this->findOrCreateCart($maTaiKhoan);

        $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id AND ma_sach = :ma_sach";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cart_id' => $cart_id,
            ':ma_sach' => $maSach
        ]);
    }
}

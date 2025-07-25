<?php

namespace App\Models;

use PDO;

class Product
{
    private $pdo;

    // Thuộc tính sản phẩm
    public $ma_sach;
    public $ten_sach;
    public $tac_gia; // Thêm thuộc tính này
    public $gia;
    public $so_luong;
    public $ma_the_loai;
    public $duong_dan;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ✅ Lấy 1 sản phẩm theo ID (kèm ảnh)
    public function find($ma_sach)
    {
        try {
            $sql = "SELECT s.*, h.duong_dan 
                    FROM sach s 
                    LEFT JOIN hinh_anh h ON s.ma_sach = h.ma_sach 
                    WHERE s.ma_sach = :ma_sach LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['ma_sach' => $ma_sach]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                foreach ($data as $key => $value) {
                    $this->$key = $value;
                }
                return $this;
            }
            return null;
        } catch (\PDOException $e) {
            error_log("Lỗi khi tìm sản phẩm: " . $e->getMessage());
            return null;
        }
    }

    // ✅ Lấy số lượng tồn kho từ object đã load
    public function getStock_product()
    {
        return intval($this->so_luong ?? 0);
    }

    // ✅ Tạo sản phẩm mới
   public function createProduct($ten_sach, $tac_gia, $gia, $so_luong, $ma_the_loai, $duong_dan = null)
{
    try {
        $this->pdo->beginTransaction();

        // Thêm sách vào bảng `sach`
        $stmt = $this->pdo->prepare("
            INSERT INTO sach (ten_sach, tac_gia, gia, so_luong, ma_the_loai) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$ten_sach, $tac_gia, $gia, $so_luong, $ma_the_loai]);

        $ma_sach = $this->pdo->lastInsertId();

        // Nếu có ảnh thì thêm vào bảng `hinh_anh`
        if ($duong_dan) {
            $stmtImg = $this->pdo->prepare("
                INSERT INTO hinh_anh (ma_sach, duong_dan) 
                VALUES (?, ?)
            ");
            $stmtImg->execute([$ma_sach, $duong_dan]);
        }

        $this->pdo->commit();
        return true;

    } catch (\PDOException $e) {
        $this->pdo->rollBack();

        // Ghi log nếu muốn
        error_log("Lỗi khi thêm sách: " . $e->getMessage());

       
        // echo "Lỗi: " . $e->getMessage();

        return false;
    }
}


    // ✅ Cập nhật sản phẩm
    public function updateProduct($id, $ten_sach, $tac_gia, $gia, $so_luong, $duong_dan = null)
{
    $this->pdo->beginTransaction();
    try {
        $stmt = $this->pdo->prepare("
            UPDATE sach 
            SET ten_sach = ?, tac_gia = ?, gia = ?, so_luong = ? 
            WHERE ma_sach = ?
        ");
        $stmt->execute([$ten_sach, $tac_gia, $gia, $so_luong, $id]);

        if ($duong_dan !== null && $duong_dan !== '') {
            $stmtImg = $this->pdo->prepare("
                INSERT INTO hinh_anh (ma_sach, duong_dan) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE duong_dan = VALUES(duong_dan)
            ");
            $stmtImg->execute([$id, $duong_dan]);
        }

        $this->pdo->commit();
        return true;
    } catch (\PDOException $e) {
        $this->pdo->rollBack();
        error_log("UpdateProduct error: " . $e->getMessage());
        return false;
    }
}



    // ✅ Xoá sản phẩm
   public function deleteProduct($id)
{
    
    try {
        $this->pdo->beginTransaction();

        // Xoá hình ảnh trước (nếu cần thủ công)
        $stmt1 = $this->pdo->prepare("DELETE FROM hinh_anh WHERE ma_sach = :id");
        $stmt1->execute([':id' => $id]);

        // Sau đó xoá sách
        $stmt2 = $this->pdo->prepare("DELETE FROM sach WHERE ma_sach = :id");
        $result = $stmt2->execute([':id' => $id]);

        $this->pdo->commit();
        return $result;
    } catch (\PDOException $e) {
        $this->pdo->rollBack();
        error_log("Lỗi xoá sách: " . $e->getMessage());
        return false;
    }
}


    // ✅ Lấy tất cả sản phẩm kèm ảnh (cho danh sách chính)
    public function all(): array
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT
                    s.ma_sach,
                    s.ten_sach,
                    s.gia,
                    s.ma_the_loai,
                    MIN(h.duong_dan) AS duong_dan
                FROM
                    sach s
                LEFT JOIN
                    hinh_anh h ON s.ma_sach = h.ma_sach
                GROUP BY
                    s.ma_sach, s.ten_sach, s.gia, s.ma_the_loai
                ORDER BY
                    s.ma_sach DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Lỗi khi lấy danh sách sản phẩm: " . $e->getMessage());
            return [];
        }
    }

    // ✅ Lấy sản phẩm theo thể loại
    public function getProductsByCategory(int $ma_the_loai): array
    {
        try {
            $sql = "SELECT s.ma_sach, s.ten_sach, s.tac_gia, s.gia, h.duong_dan
                    FROM sach s
                    LEFT JOIN hinh_anh h ON s.ma_sach = h.ma_sach
                    WHERE s.ma_the_loai = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$ma_the_loai]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Lỗi khi lấy sản phẩm theo thể loại: " . $e->getMessage());
            return [];
        }
    }

    // ✅ Danh sách sản phẩm (dành cho giao diện, rút gọn)
    public function list_product(): array
    {
        try {
            $sql = "SELECT s.ten_sach, s.gia, h.duong_dan
                    FROM sach s
                    JOIN hinh_anh h ON s.ma_sach = h.ma_sach";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Lỗi khi lấy danh sách rút gọn sản phẩm: " . $e->getMessage());
            return [];
        }
    }

    public function getLatestBooks($limit = 10)
{
    $stmt = $this->pdo->prepare("
        SELECT s.*, h.duong_dan
        FROM sach s
        LEFT JOIN hinh_anh h ON s.ma_sach = h.ma_sach
        ORDER BY s.ngay_tao DESC
        LIMIT ?
    ");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
public function getAllWithImages()
{
    $sql = "SELECT sach.ma_sach AS ma_sach, sach.ten_sach, sach.gia, hinh_anh.duong_dan
            FROM sach
            LEFT JOIN hinh_anh ON sach.ma_sach = hinh_anh.ma_sach
            ORDER BY sach.ma_sach DESC";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getCategories()
    {
        $stmt = $this->pdo->query("SELECT ma_the_loai, ten_the_loai FROM the_loai ORDER BY ten_the_loai ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // ✅ Hàm hỗ trợ bảo vệ HTML
    private function html_escape(string|null $text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8', false);
    }

public function getBooksByAuthor(string $tac_gia): array
{
    try {
        $sql = "SELECT s.ma_sach, s.ten_sach, s.tac_gia, s.gia, h.duong_dan
                FROM sach s
                LEFT JOIN hinh_anh h ON s.ma_sach = h.ma_sach
                WHERE s.tac_gia = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tac_gia]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Lỗi khi lấy sách theo tác giả: " . $e->getMessage());
        return [];
    }
}

public function addContact($ten, $email, $chu_de, $noi_dung)
{
    try {
        $stmt = $this->pdo->prepare("
            INSERT INTO lien_he (ho_ten, email, van_de_chinh, noi_dung, thoi_gian_gui)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$ten, $email, $chu_de, $noi_dung]);
        return true;
    } catch (\PDOException $e) {
       
        return $e->getMessage();
    }
}
}
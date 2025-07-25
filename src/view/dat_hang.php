<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php

use App\Models\CartModel;

$selected = json_decode($_POST['san_pham_chon_json'] ?? '[]', true);
$cartModel = new CartModel($pdo);
$cartItems = $cartModel->getCartItemsByUserId($_SESSION['user']['ma_tai_khoan']);
$selectedItems = array_filter($cartItems, fn($item) => in_array($item['ma_sach'], $selected));
$tongTien = array_reduce($selectedItems, fn($sum, $item) => $sum + $item['so_luong'] * $item['gia'], 0);
?>

<div class="container my-5">
    <h2 class="mb-4 text-center">📦 Thông tin đặt hàng</h2>

    <?php if (empty($selectedItems)): ?>
        <div class="alert alert-warning text-center">Bạn chưa chọn sản phẩm nào để đặt hàng.</div>
        <div class="text-center"><a href="/cart" class="btn btn-outline-primary">⬅ Quay lại giỏ hàng</a></div>
    <?php else: ?>
        <form method="POST" action="/dat-hang/xac-nhan">
            <!-- THÔNG TIN GIAO HÀNG -->
            <h5 class="mt-4">📝 Thông tin giao hàng</h5>
            <div class="mb-3">
                <label class="form-label">Họ tên người nhận</label>
                <input type="text" class="form-control" name="ho_ten" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="sdt" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ giao hàng</label>
                <textarea class="form-control" name="dia_chi" rows="2" required></textarea>
            </div>

            <!-- PHƯƠNG THỨC THANH TOÁN -->
            <h5 class="mt-4">💳 Phương thức thanh toán</h5>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="cod" value="COD" checked>
                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="phuong_thuc" id="bank" value="Bank">
                    <label class="form-check-label" for="bank">Thanh toán bằng thẻ ngân hàng</label>
                </div>
            </div>

            <!-- MÃ QR -->
            <div id="qrContainer" class="text-center my-4" style="display:none;">
                <p class="fw-bold">📱 Quét mã QR để chuyển khoản:</p>
                <img src="/img/QR_TT.jpg" alt="Mã QR thanh toán" style="max-width: 200px;">
                <p class="text-muted fst-italic mt-2">Vui lòng chuyển đúng số tiền và nội dung để hệ thống xác nhận đơn.</p>
            </div>

            <!-- DANH SÁCH SẢN PHẨM -->
            <h5 class="mt-4">🛍️ Sản phẩm đã chọn</h5>
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($selectedItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['ten_sach']) ?></td>
                            <td><?= $item['so_luong'] ?></td>
                            <td><?= number_format($item['gia'], 0, ',', '.') ?>đ</td>
                            <td><?= number_format($item['so_luong'] * $item['gia'], 0, ',', '.') ?>đ</td>
                        </tr>
                        <input type="hidden" name="selected_items[]" value="<?= $item['ma_sach'] ?>">
                    <?php endforeach; ?>
                    <tr class="table-warning">
                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td><strong><?= number_format($tongTien, 0, ',', '.') ?>đ</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- NÚT XÁC NHẬN -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg">✅ Xác nhận đặt hàng</button>
            </div>
        </form>

        <!-- SCRIPT xử lý hiển thị mã QR -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const radios = document.querySelectorAll('input[name="phuong_thuc"]');
                const qrBox = document.getElementById('qrContainer');

                function toggleQR() {
                    const selected = document.querySelector('input[name="phuong_thuc"]:checked').value;
                    qrBox.style.display = (selected === 'Bank') ? 'block' : 'none';
                }

                radios.forEach(r => r.addEventListener('change', toggleQR));
                toggleQR();
            });
        </script>
    <?php endif; ?>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
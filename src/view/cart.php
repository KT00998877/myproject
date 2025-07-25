<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<body>
    <div class="container my-5">
        <h2 class="mb-4 text-center">🛒 Giỏ hàng của bạn</h2>

        <?php if (empty($cartItems)): ?>
            <div class="alert alert-info text-center">Giỏ hàng của bạn hiện đang trống.</div>
        <?php else: ?>
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Chọn</th>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <?php
                        $soLuong = (int) $item['so_luong'];
                        $gia = (float) $item['gia'];
                        $thanhTien = $soLuong * $gia;
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="item-checkbox" value="<?= $item['ma_sach'] ?>" data-price="<?= $thanhTien ?>" checked>
                            </td>
                            <td><?= htmlspecialchars($item['ten_sach']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <form method="POST" action="/cart/update" class="d-inline me-1">
                                        <input type="hidden" name="ma_sach" value="<?= $item['ma_sach'] ?>">
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">−</button>
                                    </form>
                                    <span><?= $soLuong ?></span>
                                    <form method="POST" action="/cart/update" class="d-inline ms-1">
                                        <input type="hidden" name="ma_sach" value="<?= $item['ma_sach'] ?>">
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                                    </form>
                                </div>
                            </td>
                            <td><?= number_format($gia, 0, ',', '.') ?>đ</td>
                            <td><?= number_format($thanhTien, 0, ',', '.') ?>đ</td>
                            <td>
                                <form method="POST" action="/cart/delete" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');">
                                    <input type="hidden" name="ma_sach" value="<?= $item['ma_sach'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">🗑 Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-warning">
                        <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td><strong><span id="totalAmount">0</span>đ</strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- Form đặt hàng nằm riêng để tránh bị lỗi submit nhầm -->
            <form method="POST" action="/dat-hang" id="checkoutForm">
                <input type="hidden" name="san_pham_chon_json" id="selectedItemsJson">
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-success btn-lg">✅ Đặt hàng</button>
                </div>
            </form>

            <script>
                function updateTotal() {
                    let total = 0;
                    document.querySelectorAll('.item-checkbox').forEach(cb => {
                        if (cb.checked) total += parseFloat(cb.dataset.price);
                    });
                    document.getElementById('totalAmount').textContent = total.toLocaleString('vi-VN');
                }

                function prepareCheckout() {
                    const selected = [];
                    document.querySelectorAll('.item-checkbox').forEach(cb => {
                        if (cb.checked) selected.push(cb.value);
                    });
                    document.getElementById('selectedItemsJson').value = JSON.stringify(selected);
                }

                document.addEventListener('DOMContentLoaded', () => {
                    updateTotal();
                    document.querySelectorAll('.item-checkbox').forEach(cb => {
                        cb.addEventListener('change', updateTotal);
                    });
                    document.getElementById('checkoutForm').addEventListener('submit', prepareCheckout);
                });
            </script>
        <?php endif; ?>
    </div>
</body>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
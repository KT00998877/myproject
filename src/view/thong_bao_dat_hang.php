<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>

<div class="container my-5 text-center">
    <h2>🎉 Đặt hàng thành công!</h2>
    <p><strong>Đơn hàng #<?= $maHoaDon ?></strong> đã được ghi nhận.</p>
    <p>Giao tới: <strong><?= htmlspecialchars($hoTen) ?></strong> – <?= htmlspecialchars($sdt) ?></p>
    <p>Địa chỉ: <?= htmlspecialchars($diaChi) ?></p>
    <p>
        <a href="/" class="btn btn-success mt-3">⬅ Về trang chủ</a>
        <a href="/cart" class="btn btn-outline-primary mt-3">🛒 Xem giỏ hàng</a>
    </p>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
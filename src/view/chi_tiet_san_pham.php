<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4"><?= htmlspecialchars($sach['ten_sach']) ?></h2>

    <div class="row">
        <div class="col-md-4 text-center">
            <?php
            $anh = $sach['duong_dan'] ?? '';
            $duongDanWeb = str_replace('./', '/', $anh); // Chuyển './img/...' thành '/img/...'

            // Nếu rỗng thì dùng ảnh mặc định
            if (empty($duongDanWeb)) {
                $duongDanWeb = '/img/default.webp';
            }
            ?>
            <img src="<?= htmlspecialchars($duongDanWeb) ?>" alt="Ảnh sách" class="img-fluid rounded shadow-sm">
        </div>

        <div class="col-md-8">
            <p><strong>Tác giả:</strong> <?= htmlspecialchars($sach['tac_gia'] ?? 'Đang cập nhật') ?></p>
            <p><strong>Nhà xuất bản:</strong> <?= htmlspecialchars($sach['ten_nxb'] ?? 'Đang cập nhật') ?></p>
            <p><strong>Giá:</strong> <?= number_format($sach['gia'], 0, ',', '.') ?> VND</p>
            <p><strong>Mô tả:</strong><br><?= nl2br(htmlspecialchars($sach['mo_ta'] ?? '')) ?></p>

            <form method="post" action="/add-to-cart" class="mt-3">
                <input type="hidden" name="product_id" value="<?= $sach['ma_sach'] ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-success">🛒 Thêm vào giỏ</button>
                <a href="/" class="btn btn-outline-secondary ms-2">⬅ Quay lại</a>
            </form>
        </div>
    </div>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
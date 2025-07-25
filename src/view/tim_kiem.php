<?php require_once BASE_VIEW_PATH . '/layout/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$isAdmin = ($user['vai_tro'] ?? $user['role'] ?? '') === 'quan_tri';
?>

<body>
    <div class="container-fluid">
        <h1 class="text-center mb-4 py-3 bg-light">🔍 Kết quả tìm kiếm</h1>
        <div class="row no-gutters">
            <?php if (empty($ketQua)): ?>
                <div class="col-12 text-center">
                    <p class="alert alert-warning">Không tìm thấy sách nào phù hợp với từ khóa bạn vừa nhập.</p>
                </div>
            <?php else: ?>
                <?php foreach ($ketQua as $product): ?>
                    <?php
                    $maSach = html_escape($product['ma_sach'] ?? null);
                    $name = html_escape($product['ten_sach'] ?? 'N/A');
                    $price = html_escape($product['gia'] ?? '0');
                    $duongDanGoc = $product['duong_dan'] ?? '';
                    $imagePath = !empty($duongDanGoc) ? str_replace('./', '/', $duongDanGoc) : '/img/default.webp';
                    $imagePath = html_escape($imagePath);
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            <img src="<?= $imagePath ?>" class="card-img-top product-image" alt="Hình ảnh của <?= $name ?>">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center p-2 mb-0"><?= $name ?></h5>
                                <p class="card-text flex-grow-1"><strong>Giá:</strong> <?= number_format((float)$price, 0, ',', '.') ?> VND</p>

                                <form method="post" action="/add-to-cart">
                                    <input type="hidden" name="product_id" value="<?= $maSach ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-block mt-auto">Mua hàng</button>

                                    <?php if ($isAdmin): ?>
                                        <div class="mt-2 d-flex justify-content-between">
                                            <a href="/admin/products/edit/<?= $maSach ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                                            <a href="/admin/products/delete/<?= $maSach ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xoá sản phẩm này?')">🗑️ Xoá</a>
                                        </div>
                                    <?php endif; ?>
                                </form>

                                <div class="mt-2">
                                    <a href="/sanpham/<?= $maSach ?>" class="btn btn-outline-secondary btn-sm w-100">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
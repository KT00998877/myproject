<?php
require_once BASE_VIEW_PATH . '/layout/header.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$user = $_SESSION['user'] ?? null;
$isAdmin = ($user['vai_tro'] ?? $user['role'] ?? '') === 'quan_tri';
?>

<?php if (!empty($_SESSION['notification'])): ?>
    <div class="alert alert-info text-center">
        <?= $_SESSION['notification'];
        unset($_SESSION['notification']); ?>
    </div>
<?php endif; ?>

<body>
    <div class="container-fluid">
        <h1 class="text-center mb-4 py-3 bg-light">📘 Danh sách Sách Thiếu Nhi</h1>

        <div class="row no-gutters">
            <?php if (empty($TNproducts)): ?>
                <div class="col-12 text-center">
                    <p class="alert alert-warning">Không có sản phẩm nào để hiển thị.</p>
                </div>
            <?php else: ?>
                <?php foreach ($TNproducts as $product): ?>
                    <?php
                    $maSach = htmlspecialchars($product['ma_sach'] ?? '', ENT_QUOTES, 'UTF-8');
                    $name = htmlspecialchars($product['ten_sach'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
                    $price = htmlspecialchars($product['gia'] ?? '0', ENT_QUOTES, 'UTF-8');
                    $duongDanGoc = $product['duong_dan'] ?? '';
                    $imagePath = !empty($duongDanGoc) ? str_replace('./', '/', $duongDanGoc) : '/img/default.webp';
                    $imagePath = htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4">
                        <div class="card product-card h-100 shadow-sm">
                            <img src="<?= $imagePath ?>" class="card-img-top product-image" alt="Hình ảnh của <?= $name ?>">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center p-2 mb-0"><?= $name ?></h5>
                                <p class="card-text flex-grow-1"><strong>Giá:</strong> <?= number_format((float)$price, 0, ',', '.') ?> VND</p>

                                <!-- 🔘 Nhóm nút Mua hàng + Chi tiết -->
                                <div class="mt-auto d-grid gap-2">
                                    <form method="post" action="/add-to-cart">
                                        <input type="hidden" name="product_id" value="<?= $maSach ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary w-100">🛒 Mua hàng</button>
                                    </form>

                                    <a href="/sanpham/<?= $maSach ?>" class="btn btn-outline-secondary w-100">🔍 Chi tiết</a>

                                    <?php if ($isAdmin): ?>
                                        <div class="d-flex justify-content-between mt-2">
                                            <a href="/admin/products/edit/<?= $maSach ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                                            <a href="/admin/products/delete/<?= $maSach ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xoá sản phẩm này?')">🗑️ Xoá</a>
                                        </div>
                                    <?php endif; ?>
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
<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<?php
require_once BASE_VIEW_PATH . '/layout/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? null;
$isAdmin = ($user['vai_tro'] ?? $user['role'] ?? '') === 'quan_tri';
?>
<?php if (!empty($_SESSION['notification'])): ?>
    <div class="alert alert-info text-center">
        <?= $_SESSION['notification'];
        unset($_SESSION['notification']); ?>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">📚 Sách Mới</h2>
    <div class="row">
        <?php foreach ($sachMoi as $sach): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <?php if (!empty($sach['duong_dan'])): ?>
                        <img src="<?= htmlspecialchars($sach['duong_dan']) ?>" class="card-img-top" alt="Ảnh bìa của sách <?= htmlspecialchars($sach['ten_sach']) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($sach['ten_sach']) ?></h5>
                        <p class="card-text">Tác giả: <?= htmlspecialchars($sach['tac_gia']) ?></p>
                        <p class="card-text">Giá: <?= number_format($sach['gia'], 0, ',', '.') ?> VND</p>
                        <a href="#" class="btn btn-primary btn-block mt-auto">🛒 Mua hàng</a>

                        <?php if ($isAdmin): ?>
                            <div class="mt-2 d-flex justify-content-between">
                                <a href="/admin/products/edit/<?= htmlspecialchars($sach['ma_sach']) ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                                <a href="/admin/products/delete/<?= htmlspecialchars($sach['ma_sach']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xoá sản phẩm này?')">🗑️ Xoá</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
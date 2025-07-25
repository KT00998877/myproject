<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Chỉnh sửa sản phẩm</h2>

    <form method="POST" class="card p-4 shadow" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="ten_sach" class="form-label">Tên sách</label>
            <input type="text" class="form-control" name="ten_sach" value="<?= htmlspecialchars($product->ten_sach) ?>" required>
        </div>

        <div class="mb-3">
            <label for="tac_gia" class="form-label">Tác giả</label>
            <input type="text" class="form-control" name="tac_gia" value="<?= htmlspecialchars($product->tac_gia) ?>" required>
        </div>

        <div class="mb-3">
            <label for="gia" class="form-label">Giá (VNĐ)</label>
            <input type="number" class="form-control" name="gia" min="0" step="0.01" value="<?= htmlspecialchars($product->gia) ?>" required>
        </div>

        <div class="mb-3">
            <label for="so_luong" class="form-label">Số lượng</label>
            <input type="number" class="form-control" name="so_luong" min="1" value="<?= htmlspecialchars($product->so_luong) ?>" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
            <a href="/admin/products" class="btn btn-secondary">↩️ Quay lại</a>
        </div>
    </form>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>

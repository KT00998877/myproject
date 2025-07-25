<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Thêm sản phẩm mới</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow">
        <div class="mb-3">
            <label for="ten_sach" class="form-label">Tên sách</label>
            <input type="text" class="form-control" name="ten_sach"
                value="<?= htmlspecialchars($_POST['ten_sach'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="tac_gia" class="form-label">Tác giả</label>
            <input type="text" class="form-control" name="tac_gia"
                value="<?= htmlspecialchars($_POST['tac_gia'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="ma_the_loai" class="form-label">Thể loại</label>
            <select name="ma_the_loai" class="form-select" required>
                <option value="">-- Chọn thể loại --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ma_the_loai'] ?>"
                        <?= (isset($_POST['ma_the_loai']) && $_POST['ma_the_loai'] == $category['ma_the_loai']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['ten_the_loai']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['ma_the_loai'])): ?>
                <div class="text-danger mt-1"><?= htmlspecialchars($errors['ma_the_loai']) ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="gia" class="form-label">Giá (VNĐ)</label>
            <input type="number" class="form-control" name="gia" min="0" step="0.01"
                value="<?= htmlspecialchars($_POST['gia'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="so_luong" class="form-label">Số lượng</label>
            <input type="number" class="form-control" name="so_luong" min="1"
                value="<?= htmlspecialchars($_POST['so_luong'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="hinh_anh" class="form-label">Hình ảnh</label>
            <input type="file" onchange="previewImage(event)" class="form-control" name="hinh_anh" accept="image/*">
            <div class="mt-3">
                <img id="preview" src="#" alt="Preview hình ảnh"
                    style="display: none; max-height: 200px;" class="img-thumbnail">
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">➕ Thêm sản phẩm</button>
            <a href="/admin/products" class="btn btn-secondary">↩️ Quay lại</a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>

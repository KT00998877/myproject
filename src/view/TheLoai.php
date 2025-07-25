<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<h2><?= htmlspecialchars($category['ten_the_loai'] ?? 'Thể loại') ?></h2>
<ul>
    <?php foreach ($books as $book): ?>
        <li>
            <?= htmlspecialchars($book['ten_sach']) ?> - <?= number_format($book['gia']) ?> VNĐ
        </li>
    <?php endforeach; ?>
    <?php if (empty($books)): ?>
        <li>Không có sách trong thể loại này.</li>
    <?php endif; ?>
</ul>
<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
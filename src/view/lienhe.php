<?php
require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/../helpers/csrf.php';?>
<?php if (!empty($_SESSION['error_message'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
  <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="container pb-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <h2 class="mb-4">Gửi tin nhắn cho Kahasa</h2>

            <?php if (isset($thongBao)): ?>
                <div class="alert alert-info"><?= htmlspecialchars($thongBao) ?></div>
            <?php endif; ?>

            <div class="card p-4 shadow-sm">
                <!-- kiểm tra CSRF token -->
                
                <form method="post" action="/lienhe">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="fullName" name="ten" placeholder="Nhập họ và tên của bạn" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập địa chỉ email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Chủ đề</label>
                        <input type="text" class="form-control" id="subject" name="chu_de" placeholder="Bạn cần hỗ trợ về vấn đề gì?" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="message" name="noi_dung" rows="5" placeholder="Nội dung chi tiết" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Gửi Tin Nhắn</button>
                </form>
            </div>
        </div>
    
        <div class="col-lg-5">
            <h2 class="mb-4">Thông tin liên hệ</h2>
            <div class="card p-4 shadow-sm h-100">
                <div class="contact-info d-flex align-items-start mb-4">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <h5 class="mb-1">Địa chỉ</h5>
                        <p>132, đường 3/2, quận Ninh Kiều, Thành Phố Cần THơ</p>
                    </div>
                </div>
                <div class="contact-info d-flex align-items-start mb-4">
                    <i class="bi bi-telephone-fill"></i>
                    <div>
                        <h5 class="mb-1">Điện thoại</h5>
                        <p>1900 1234</p>
                    </div>
                </div>
                <div class="contact-info d-flex align-items-start mb-4">
                    <i class="bi bi-envelope-fill"></i>
                    <div>
                        <h5 class="mb-1">Email</h5>
                        <p>hotro@kahasa.vn</p>
                    </div>
                </div>
                <div class="contact-info d-flex align-items-start">
                    <i class="bi bi-clock-fill"></i>
                    <div>
                        <h5 class="mb-1">Giờ làm việc</h5>
                        <p>Thứ 2 - Thứ 7: 8:00 - 21:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
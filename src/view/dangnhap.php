
<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/../helpers/csrf.php';?>
<?php if (!empty($_SESSION['error_message'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
  <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['success_message'])): ?>
  <div class="alert alert-success">
    <?= htmlspecialchars($_SESSION['success_message']) ?>
  </div>
  <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="section section-login bg-dark text-white py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6">
        <div class="card shadow-lg">
          <div class="card-body">
            <h3 class="text-center mb-4">Chào mừng bạn đến với Kahasa</h3>

            <div class="d-flex justify-content-center gap-3 mb-4">
              <a href="#" class="btn btn-outline-primary rounded-circle">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="btn btn-outline-danger rounded-circle">
                <i class="fab fa-google-plus-g"></i>
              </a>
              <a href="#" class="btn btn-outline-info rounded-circle">
                <i class="fab fa-twitter"></i>
              </a>
            </div>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        
            <form method="POST" action="/dangnhap">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
              <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control <?= isset($error) && empty($username) ? 'is-invalid' : '' ?>"
                         id="username" name="username" placeholder="Tên đăng nhập"
                         value="<?= htmlspecialchars($username ?? '') ?>">
                </div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-key"></i></span>
                  <input type="password" class="form-control <?= isset($error) && empty($password) ? 'is-invalid' : '' ?>"
                         id="password" name="password" placeholder="Mật khẩu">
                </div>
              </div>

              <button type="submit" class="btn btn-danger w-100 rounded-pill">Đăng nhập</button>
            </form>

            <div class="text-center mt-3">
              <a href="/dangky" class="text-danger text-decoration-none">Bạn chưa có tài khoản?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>


<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/../helpers/csrf.php';?>
<?php if (!empty($_SESSION['error_message'])): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
  <?php unset($_SESSION['error_message']); ?>
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


            <?php if (!empty($errors['general'])): ?>
              <div class="alert alert-danger">
                <?= htmlspecialchars($errors['general']) ?>
              </div>
            <?php endif; ?>

            
            <form method="POST" action="/dangky">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
              <!-- Tên đăng nhập -->
              <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-user"></i></span>
                  <input type="text" name="username" id="username"
                    class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                    placeholder="Tên đăng nhập" value="<?= htmlspecialchars($username) ?>">
                  <?php if (isset($errors['username'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  <input type="email" name="email" id="email"
                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                    placeholder="Email" value="<?= htmlspecialchars($email) ?>">
                  <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-key"></i></span>
                  <input type="password" name="password" id="password"
                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                    placeholder="Mật khẩu">
                  <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                  <?php endif; ?>
                </div>
              </div>
              <!-- Xác nhận mật khẩu -->
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Nhập lại mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-key"></i></span>
                  <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                    placeholder="Nhập lại mật khẩu">
                  <?php if (isset($errors['confirm_password'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['confirm_password']) ?></div>
                  <?php endif; ?>
                </div>
              </div>


              <button type="submit" class="btn btn-danger w-100 rounded-pill">Đăng ký</button>
            </form>

            <div class="text-center mt-3">
              <a href="#" class="text-danger text-decoration-none">Quên mật khẩu?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
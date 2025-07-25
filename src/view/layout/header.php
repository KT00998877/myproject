<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cartCount = $_SESSION['cart_count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Nhà Sách Online - Kahasa - Nhà sách số 1 Việt Nam</title>

  <link rel="icon" href="/assets/img/favicon.png">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/css/custom.css" rel="stylesheet" />
  <link href="/css/book.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body class="index-page sidebar-collapse">
  <nav class="navbar navbar-expand-lg fixed-top navbar-transparent" color-on-scroll="300">
    <div class="container-fluid color-on-scroll">
      <div class="navbar-translate d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="/">
          <img src="/img/logo.png" alt="Kahasa Logo" style="height: 100px; width: auto;">
          Trang Chủ 
        </a>
        <button class="navbar-toggler d-lg-none" type="button"
          data-bs-toggle="collapse" data-bs-target="#navigation"
          aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse justify-content-end" id="navigation">
        <ul class="navbar-nav d-flex gap-3 align-items-center">
          <li class="nav-item"><a class="nav-link btn-default btn-lg" href="/gioithieu" target="_blank">Giới thiệu</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle btn-default btn-lg" href="#" id="theloaiDropdown" role="button"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thể Loại</a>
            <div class="dropdown-menu" aria-labelledby="theloaiDropdown">
              <a class="dropdown-item" href="/kinhte">Sách Kinh Tế</a>
              <a class="dropdown-item" href="/vanhoc">Sách Văn Học</a>
              <a class="dropdown-item" href="/khoahoc">Sách Khoa Học</a>
              <a class="dropdown-item" href="/thieunhi">Sách Thiếu Nhi</a>
              <a class="dropdown-item" href="/tamly">Sách Tâm lý-Kỹ Năng</a>
              <a class="dropdown-item" href="/ngoaingu">Sách Ngoại Ngữ</a>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link btn-default btn-lg" href="/tintuc" target="_blank">Tin tức</a></li>
          <li class="nav-item"><a class="nav-link btn-default btn-lg" href="/lienhe" target="_blank">Liên Hệ</a></li>
          <li class="nav-item"><a class="nav-link btn-default btn-lg" href="/sachmoi" target="_blank">Sách Mới</a></li>

          <!-- 🔍 Thanh tìm kiếm -->
          <li class="nav-item">
            <form method="get" action="/tim-kiem" class="d-flex">
              <input type="text" name="q" class="form-control me-2" placeholder="Tìm sách..." />
              <button type="submit" class="btn btn-outline-light">🔍</button>
            </form>
          </li>

          <!-- 🛒 Giỏ hàng -->
          <li class="nav-item cart-item">
            <a href="/cart" class="cart-icon btn btn-danger btn-round">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
              <?php if ($cartCount > 0): ?>
                <span class="badge badge-light" style="position:absolute;top:0;right:0;"><?php echo $cartCount; ?></span>
              <?php endif; ?>
            </a>
          </li>

          <!-- 👤 Tài khoản -->
          <?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item">
              <a href="/dangxuat" class="nav-link btn btn-outline-danger btn-round">
                Đăng xuất <i class="fa-solid fa-right-from-bracket"></i>
              </a>
            </li>
          <?php else: ?>
            <li class="nav-item dropdown">
              <a class="nav-link btn btn-default btn-round dropdown-toggle custom-dropdown-toggle" href="#" id="userDropdown"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user user-icon-large"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/dangnhap">Đăng nhập</a>
                <a class="dropdown-item" href="/dangky">Đăng ký</a>
              </div>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Banner -->
  <div class="page-header section-dark" style="background-image: url('/img/background.jpg')">
    <div class="filter"></div>
    <div class="content-center">
      <div class="container">
        <div class="overlay"></div>
        <h1 class="presentation-title text-center">Kahasa</h1>
        <div class="moving-clouds" style="background-image: url('/img/clouds.png');"></div>
        <h1 class="presentation-subtitle text-center">Sách hay cho mọi nhà</h1>
        <h4 class="presentation-subtitle text-center">
          Chào mừng bạn đến với Kahasa – nền tảng mua sắm sách trực tuyến hiện đại và đáng tin cậy dành cho mọi độc giả Việt Nam.<br>
          Tại Kahasa, chúng tôi tin rằng mỗi cuốn sách là một cánh cửa mở ra tri thức, cảm hứng và tương lai.<br>
          Với hàng triệu đầu sách đa dạng từ văn học, khoa học, giáo dục đến giải trí, Kahasa mang đến trải nghiệm mua sắm tiện lợi.<br>
          Hãy cùng khám phá thế giới sách tại Kahasa ngay hôm nay!
        </h4>
      </div>
    </div>
  </div>
<?php require_once BASE_VIEW_PATH . '/layout/header.php'; ?>
<main class="container my-5">
    <section id="about" class="py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="/img/gioithieu.jpg" class="img-fluid rounded-3 shadow-lg" alt="Không gian đọc sách ấm cúng">
            </div>
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold lh-1 mb-3">Về Kahasa: Nơi Tình Yêu Sách Bắt Đầu</h2>
                <p class="lead">Kahasa được thành lập với một sứ mệnh đơn giản nhưng đầy nhiệt huyết: lan tỏa tri thức và niềm đam mê đọc sách đến mọi người. Chúng tôi tin rằng mỗi trang sách mở ra là một chân trời mới, một cơ hội để học hỏi và trưởng thành.</p>
                <p>Với kho sách đa dạng gồm hàng trăm ngàn đầu sách từ kinh điển đến hiện đại, Kahasa tự hào là người bạn đồng hành tin cậy của độc giả Việt Nam. Chúng tôi cam kết mang đến những cuốn sách chất lượng với dịch vụ tận tâm nhất.</p>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section id="features" class="py-5 text-center">
        <h2 class="fw-bold mb-5">Giá Trị Cốt Lõi Của Kahasa</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-icon mb-3">
                    <i class="bi bi-book-half"></i>
                </div>
                <h4 class="fw-bold">Kho Sách Khổng Lồ</h4>
                <p>Hơn 200.000 đầu sách thuộc mọi lĩnh vực, liên tục được cập nhật để bạn không bỏ lỡ bất kỳ cuốn sách hay nào.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-icon mb-3">
                    <i class="bi bi-truck"></i>
                </div>
                <h4 class="fw-bold">Giao Hàng Siêu Tốc</h4>
                <p>Hệ thống vận hành hiện đại đảm bảo sách đến tay bạn nhanh chóng. Miễn phí vận chuyển cho đơn hàng từ 150.000đ.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-icon mb-3">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h4 class="fw-bold">Chất Lượng Đảm Bảo</h4>
                <p>100% sách chính hãng, có bản quyền từ các nhà xuất bản uy tín. Nói không với sách giả, sách kém chất lượng.</p>
            </div>
        </div>
    </section>
    <hr class="my-5">

    <section id="author-spotlight" class="py-5 bg-light rounded-3">
        <h2 class="fw-bold text-center mb-5">Tác Giả Của Tháng ✨</h2>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-3 text-center">
                <img src="/img/NNA.jpg" class="img-fluid rounded-circle shadow" style="width: 180px; height: 180px; object-fit: cover;" alt="Tác giả Nguyễn Nhật Ánh">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Nguyễn Nhật Ánh</h3>
                <p class="fst-italic">"Nhà văn của tuổi thơ và những ký ức trong veo."</p>
                <p>Với lối viết giản dị, trong sáng và hóm hỉnh, Nguyễn Nhật Ánh đã tạo ra một vũ trụ văn học đầy màu sắc, nơi tuổi học trò
                    được tái hiện một cách chân thực và đầy hoài niệm. Những tác phẩm của ông không chỉ dành cho thiếu nhi mà còn chạm đến trái tim của mọi lứa tuổi.</p>

                <?php if (!empty($GTproducts)): ?>
                    <section class="mt-5">
                        <h3 class="fw-bold text-center mb-4">Tác phẩm của <?= htmlspecialchars($GTproducts[0]['tac_gia']) ?></h3>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <?php foreach ($GTproducts as $book): ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <img src="<?= htmlspecialchars($book['duong_dan']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($book['ten_sach']) ?></h5>
                                            <p class="card-text">Giá: <?= number_format($book['gia'], 0, ',', '.') ?>đ</p>
                                            <div class="mt-auto d-grid gap-2">
                                                <form method="post" action="/add-to-cart">
                                                    <input type="hidden" name="product_id" value="<?= $maSach ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-primary w-100">🛒 Mua</button>
                                                </form>
                                                <a href="/sanpham/<?= $maSach ?>" class="btn btn-outline-secondary w-100">🔍 Chi tiết</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                    </section>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <hr class="my-5">

    <section id="testimonial" class="p-5 my-5 bg-light border rounded-3 shadow-lg">
        <h2 class="fw-bold text-center mb-4">Khách Hàng Nói Gì Về Kahasa 💬</h2>

        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-theme="dark">
            <div class="carousel-inner text-center w-75 mx-auto">
                <div class="carousel-item active">
                    <p class="lead fst-italic">"Giao hàng siêu nhanh, sách được bọc cẩn thận. Mình rất hài lòng và sẽ tiếp tục ủng hộ Kahasa."</p>
                    <p class="fw-bold mt-3">- Minh Anh, Hà Nội</p>
                </div>
                <div class="carousel-item">
                    <p class="lead fst-italic">"Kho sách rất đa dạng, mình tìm được cả những cuốn sách cũ khó tìm. App dùng mượt, dễ thao tác. Cảm ơn Kahasa!"</p>
                    <p class="fw-bold mt-3">- Tuấn Kiệt, TP. Hồ Chí Minh</p>
                </div>
                <div class="carousel-item">
                    <p class="lead fst-italic">"Chất lượng sách không có gì để chê, 100% sách thật. Dịch vụ chăm sóc khách hàng cũng rất nhiệt tình và chu đáo."</p>
                    <p class="fw-bold mt-3">- Phương Thảo, Cần Thơ</p>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <hr class="my-5">

    <section id="newsletter" class="py-5 bg-primary text-white text-center rounded-3 shadow">
        <div class="container">
            <h2 class="display-6 fw-bold">Đừng Bỏ Lỡ Sách Hay & Ưu Đãi Tốt!</h2>
            <p class="lead">Đăng ký tài khoản nhận bản tin từ Kahasa để cập nhật những cuốn sách mới nhất, các bài review chất lượng và chương trình khuyến mãi độc quyền.</p>
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <form class="d-flex">
                        <a class="lead text-white" href="/dangky"> Đăng ký tại đây nhá </a> <br>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>
<?php require_once BASE_VIEW_PATH . '/layout/footer.php';; ?>
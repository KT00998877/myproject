CREATE TABLE cart (
    id SERIAL PRIMARY KEY,
    ma_tai_khoan INT REFERENCES tai_khoan(ma_tai_khoan) ON DELETE CASCADE,
    status VARCHAR(50) DEFAULT 'Đang xử lý', -- Hoặc 'Đã đặt hàng'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart_items (
    id SERIAL PRIMARY KEY,
    cart_id INT REFERENCES cart(id) ON DELETE CASCADE,
    ma_sach INT REFERENCES sach(ma_sach),
    so_luong INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);





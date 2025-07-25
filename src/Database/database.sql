
-- Bảng thể loại
CREATE TABLE the_loai (
    ma_the_loai SERIAL PRIMARY KEY,
    ten_the_loai VARCHAR(100) NOT NULL
);


-- Bảng sách
CREATE TABLE sach (
    ma_sach SERIAL PRIMARY KEY,
    ten_sach VARCHAR(255) NOT NULL,
    tac_gia VARCHAR(150),
    gia NUMERIC(10,2) NOT NULL,
    so_luong INT DEFAULT 0,
    ma_the_loai INT REFERENCES the_loai(ma_the_loai) ON DELETE SET NULL,
    ma_nxb INT REFERENCES nha_xuat_ban(ma_nxb) ON DELETE SET NULL,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Bảng hình ảnh
CREATE TABLE hinh_anh (
    ma_hinh SERIAL PRIMARY KEY,         
    ma_sach INT REFERENCES sach(ma_sach) ON DELETE CASCADE, 
    duong_dan TEXT NOT NULL
);  


-- Bảng nhà xuất bản
CREATE TABLE nha_xuat_ban (
    ma_nxb SERIAL PRIMARY KEY,
    ten_nxb VARCHAR(150) NOT NULL,
);


-- Bảng tài khoản
CREATE TABLE tai_khoan (
    ma_tai_khoan SERIAL PRIMARY KEY,
    ten_dang_nhap VARCHAR(50) UNIQUE NOT NULL,
    mat_khau VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    vai_tro VARCHAR(20) DEFAULT 'nguoi_dung', -- nguoi_dung | quan_tri
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng hóa đơn
CREATE TABLE hoa_don (
    ma_hoa_don SERIAL PRIMARY KEY,
    ma_tai_khoan INT REFERENCES tai_khoan(ma_tai_khoan) ON DELETE SET NULL,
    tong_tien NUMERIC(12,2) NOT NULL,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng chi tiết hóa đơn
CREATE TABLE chi_tiet_hoa_don (
    ma_cthd SERIAL PRIMARY KEY,
    ma_hoa_don INT REFERENCES hoa_don(ma_hoa_don) ON DELETE CASCADE,
    ma_sach INT REFERENCES sach(ma_sach),
    so_luong INT NOT NULL,
    don_gia NUMERIC(10,2) NOT NULL
);

CREATE TABLE lien_he (
    id serial PRIMARY KEY,
    ho_ten VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    van_de_chinh VARCHAR(255),
    noi_dung TEXT NOT NULL,
    thoi_gian_gui TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


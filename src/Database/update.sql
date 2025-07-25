select * from cart_items

select * from cart

select * from tai_khoan

select * from tai_khoan

select * from chi_tiet_hoa_don

ALTER TABLE hoa_don
ADD COLUMN ho_ten VARCHAR(100),
ADD COLUMN sdt VARCHAR(20),
ADD COLUMN dia_chi TEXT;

select * from hoa_don

/*
Created		11/15/2022
Modified		12/23/2022
Project		
Model			
Company		
Author		
Version		
Database		MS SQL 2005 
*/

use master 
go
IF EXISTS (SELECT NAME FROM SYS.Databases WHERE NAME = 'webgearvz06')
DROP Database webgearvz06
go
--Tạo CSDL
CREATE DATABASE webgearvz06
ON(NAME= 'SV_DATA',FILENAME='D:\Microsoft SQL Server\webgearvz06.MDF')
LOG ON(NAME= 'SV_LOG',FILENAME='D:\Microsoft SQL Server\webgearvz06.LDF')
Go

use webgearvz06
Create table [NHAN_VIEN]
(
	[MaNV] Char(50) NOT NULL,
	[TenDangNhapTK] Char(30) NOT NULL,
	[MaCV] Char(10) NOT NULL,
	[HoTen] Nvarchar(50) NULL,
	[SDT] Char(10) NULL,
	[DiaChi] Nvarchar(250) NULL,
	[Email] Nvarchar(40) NULL,
Primary Key ([MaNV])
) 
go

Create table [KHACH_HANG]
(
	[MaKH] Char(50) NOT NULL,
	[TenDangNhapTK] Char(30) NOT NULL,
	[HoTenKH] Nvarchar(50) NULL,
	[SDT] Char(10) NULL,
	[DiaChi] Nvarchar(250) NULL,
	[Email] Nvarchar(50) NULL,
Primary Key ([MaKH])
) 
go

Create table [SAN_PHAM]
(
	[MaSP] Char(10) NOT NULL,
	[Ma_Loai] Char(10) NOT NULL,
	[TenSP] Nvarchar(70) NULL,
	[SoLuong] Integer NULL,
	[Gia] Decimal(18,0) NULL,
	[Ma_TH] Char(10) NOT NULL,
	[GioiThieuSP] Nvarchar(5000) NULL,
	[HinhAnhSP] Nvarchar(200) NULL,
	[HinhAnhCT1] Nvarchar(200) NULL,
	[HinhAnhCT2] Nvarchar(200) NULL,
	[HinhAnhCT3] Nvarchar(200) NULL,
	[HinhAnhCT4] Nvarchar(200) NULL,
	[SLTC] Integer NULL,
	[ID] Integer NULL,
Primary Key ([MaSP])
) 
go

Create table [HOA_DON]
(
	[MaHÐ] Nvarchar(50) NOT NULL,
	[NgayLap] Nvarchar(150) NULL,
	[MaNV] Char(50) NULL,
	[MaPTTT] Char(10) NOT NULL,
	[TongHoaDon] Float NULL,
	[MaKH] Char(50) NULL,
	[TinhTrangTT] Nvarchar(50) NULL,
	[TinhTrangDH] Nvarchar(50) NULL,
	[Voucher] Nvarchar(50) NULL,
Primary Key ([MaHÐ],[MaPTTT])
) 
go

Create table [TAI_KHOAN]
(
	[TenDangNhapTK] Char(30) NOT NULL,
	[MatKhau] Nvarchar(50) NULL,
Primary Key ([TenDangNhapTK])
) 
go

Create table [CT_HD]
(
	[MaHÐ] Nvarchar(50) NOT NULL,
	[MaSP] Char(10) NOT NULL,
	[SoLuong] Integer NULL,
	[TongGia] Decimal(18,0) NULL,
	[MaPTTT] Char(10) NOT NULL,
	[NgayMua] Nvarchar(50) NULL,
Primary Key ([MaHÐ],[MaSP],[MaPTTT])
) 
go

Create table [Loai_SP]
(
	[Ma_Loai] Char(10) NOT NULL,
	[TenLoai] Nvarchar(50) NULL,
Primary Key ([Ma_Loai])
) 
go

Create table [THUONG_HIEU]
(
	[Ma_TH] Char(10) NOT NULL,
	[TenTH] Nvarchar(250) NULL,
Primary Key ([Ma_TH])
) 
go

Create table [CHUC_VU]
(
	[MaCV] Char(10) NOT NULL,
	[ChucVu] Nvarchar(20) NULL,
Primary Key ([MaCV])
) 
go

Create table [PHUONG_THUC_THANH_TOAN]
(
	[MaPTTT] Char(10) NOT NULL,
	[TenPTTT] Nvarchar(50) NOT NULL,
Primary Key ([MaPTTT])
) 
go


Alter table [HOA_DON] add  foreign key([MaNV]) references [NHAN_VIEN] ([MaNV])  on update no action on delete no action 
go
Alter table [HOA_DON] add  foreign key([MaKH]) references [KHACH_HANG] ([MaKH])  on update no action on delete no action 
go
Alter table [CT_HD] add  foreign key([MaSP]) references [SAN_PHAM] ([MaSP])  on update cascade on delete Set Default 
go
Alter table [CT_HD] add  foreign key([MaHÐ],[MaPTTT]) references [HOA_DON] ([MaHÐ],[MaPTTT])  on update no action on delete no action 
go
Alter table [NHAN_VIEN] add  foreign key([TenDangNhapTK]) references [TAI_KHOAN] ([TenDangNhapTK])  on update no action on delete no action 
go
Alter table [KHACH_HANG] add  foreign key([TenDangNhapTK]) references [TAI_KHOAN] ([TenDangNhapTK])  on update no action on delete no action 
go
Alter table [SAN_PHAM] add  foreign key([Ma_Loai]) references [Loai_SP] ([Ma_Loai])  on update no action on delete no action 
go
Alter table [SAN_PHAM] add  foreign key([Ma_TH]) references [THUONG_HIEU] ([Ma_TH])  on update no action on delete no action 
go
Alter table [NHAN_VIEN] add  foreign key([MaCV]) references [CHUC_VU] ([MaCV])  on update no action on delete no action 
go
Alter table [HOA_DON] add  foreign key([MaPTTT]) references [PHUONG_THUC_THANH_TOAN] ([MaPTTT])  on update no action on delete no action 
go


Set quoted_identifier on
go


Set quoted_identifier off
go

INSERT PHUONG_THUC_THANH_TOAN VALUES
('COD',N'Thanh toán khi nhận hàng')
go

INSERT THUONG_HIEU VALUES
('LG',N'Logitech')
go

INSERT Loai_SP VALUES
('BP',N'Bàn phím máy tính')
go

INSERT TAI_KHOAN VALUES
('Staff01','123')
go

INSERT NHAN_VIEN VALUES
('GD001','Staff01','GD',N'Admin01','0359375875',N'45, đường 10, TP.Hồ Chí Minh',N'adminvz06.01@gmail.com')
go
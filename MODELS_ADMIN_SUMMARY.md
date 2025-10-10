# 📦 MODELS STRUCTURE - ADMIN MODULE

Ngày tạo: 10/10/2025

## 📁 CẤU TRÚC MODELS THEO DOMAIN

```
app/Models/
├── Auth/                           # Authentication & Authorization
│   ├── TaiKhoan.php               ✅ Tài khoản (polymorphic với 4 actors)
│   ├── VaiTro.php                 ✅ Vai trò (admin, dao_tao, giang_vien, sinh_vien)
│   └── Quyen.php                  ✅ Quyền (permissions)
│
├── User/                          # Actors (4 loại người dùng)
│   ├── Admin.php                  ✅ Quản trị viên
│   ├── DaoTao.php                 ✅ Nhân viên phòng đào tạo
│   ├── GiangVien.php              ✅ Giảng viên
│   └── SinhVien.php               ✅ Sinh viên
│
├── Academic/                      # Cấu trúc đào tạo
│   ├── Nganh.php                  ✅ Ngành học
│   ├── ChuyenNganh.php            ✅ Chuyên ngành
│   └── MonHoc.php                 ✅ Môn học
│
├── Schedule/                      # Lịch học & Phòng học
│   └── PhongHoc.php               ✅ Phòng học
│
└── System/                        # Danh mục & Cấu hình
    ├── Khoa.php                   ✅ Khoa
    ├── KhoaHoc.php                ✅ Khóa học (2021-2025)
    ├── HocKy.php                  ✅ Học kỳ
    ├── DmTrinhDo.php              ✅ Danh mục trình độ (Thạc sĩ, Tiến sĩ...)
    ├── TrangThaiHocTap.php        ✅ Trạng thái học tập (Đang học, Bảo lưu...)
    ├── ThongBao.php               ✅ Thông báo
    └── CauHinhHeThong.php         ✅ Cấu hình hệ thống
```

---

## 📊 MODELS CHO PHẦN ADMIN

### **1. Auth Models (3 models)**

#### **TaiKhoan** - Polymorphic Account

```php
Namespace: App\Models\Auth\TaiKhoan

Fields:
- ten_dang_nhap (unique)
- mat_khau
- sinh_vien_id (nullable)
- giang_vien_id (nullable)
- dao_tao_id (nullable)
- admin_id (nullable)
- last_login
- remember_token
- email_verified_at

Relationships:
- belongsTo: SinhVien, GiangVien, DaoTao, Admin (polymorphic)
- belongsToMany: VaiTro (via tai_khoan_vai_tro)

Methods:
- isSinhVien(), isGiangVien(), isDaoTao(), isAdmin()
- getUserType()
- hasRole($roleName)
- hasPermission($permissionCode)
```

#### **VaiTro** - Role

```php
Namespace: App\Models\Auth\VaiTro

Fields:
- ten_vai_tro (unique)

Relationships:
- belongsToMany: TaiKhoan (via tai_khoan_vai_tro)
- belongsToMany: Quyen (via vai_tro_quyen)

Methods:
- hasPermission($permissionCode)
- givePermissionTo($permission)
- revokePermissionTo($permission)
```

#### **Quyen** - Permission

```php
Namespace: App\Models\Auth\Quyen

Fields:
- ma_quyen (unique)
- mo_ta

Relationships:
- belongsToMany: VaiTro (via vai_tro_quyen)
```

---

### **2. User Models (4 actors)**

#### **Admin**

```php
Namespace: App\Models\User\Admin

Fields:
- ho_ten
- email (unique)
- so_dien_thoai

Relationships:
- hasOne: TaiKhoan

Features:
- SoftDeletes
```

#### **DaoTao**

```php
Namespace: App\Models\User\DaoTao

Fields:
- ho_ten
- email (unique)
- so_dien_thoai
- phong_ban

Relationships:
- hasOne: TaiKhoan

Features:
- SoftDeletes
```

#### **GiangVien**

```php
Namespace: App\Models\User\GiangVien

Fields:
- ma_giang_vien (unique)
- ho_ten
- email (unique)
- so_dien_thoai
- trinh_do_id
- chuyen_mon
- khoa_id
- ngay_vao_truong
- anh_dai_dien

Relationships:
- belongsTo: Khoa, DmTrinhDo
- hasOne: TaiKhoan

Accessors:
- getAnhDaiDienUrlAttribute()

Features:
- SoftDeletes
```

#### **SinhVien**

```php
Namespace: App\Models\User\SinhVien

Fields:
- ma_sinh_vien (unique)
- ho_ten
- email (unique)
- ngay_sinh
- gioi_tinh (nam, nu, khac)
- so_dien_thoai
- Địa chỉ: so_nha_duong, phuong_xa, quan_huyen, tinh_thanh
- CCCD: can_cuoc_cong_dan, ngay_cap_cccd, noi_cap_cccd
- anh_dai_dien
- khoa_hoc_id
- nganh_id
- chuyen_nganh_id
- ky_hien_tai
- trang_thai_hoc_tap_id

Relationships:
- belongsTo: KhoaHoc, Nganh, ChuyenNganh, TrangThaiHocTap
- hasOne: TaiKhoan

Accessors:
- getAnhDaiDienUrlAttribute()
- getDiaChiDayDuAttribute()
- getTenDayDuAttribute()

Features:
- SoftDeletes
```

---

### **3. Academic Models (3 models)**

#### **Nganh** - Major

```php
Namespace: App\Models\Academic\Nganh

Fields:
- ten_nganh
- khoa_id

Relationships:
- belongsTo: Khoa
- hasMany: ChuyenNganh, SinhVien
```

#### **ChuyenNganh** - Specialization

```php
Namespace: App\Models\Academic\ChuyenNganh

Fields:
- ten_chuyen_nganh
- nganh_id

Relationships:
- belongsTo: Nganh
- hasMany: SinhVien, ChuongTrinhKhung
```

#### **MonHoc** - Subject

```php
Namespace: App\Models\Academic\MonHoc

Fields:
- ma_mon (unique)
- ten_mon
- so_tin_chi
- mo_ta
- loai_mon
- hinh_thuc_day (offline, online, hybrid)
- thoi_luong
- so_buoi

Relationships:
- belongsToMany: MonHoc (self-referencing - môn tiên quyết)
- hasMany: LopHocPhan, ChuongTrinhKhung

Features:
- SoftDeletes
```

---

### **4. Schedule Models (1 model)**

#### **PhongHoc** - Classroom

```php
Namespace: App\Models\Schedule\PhongHoc

Fields:
- ma_phong (unique)
- suc_chua
- vi_tri

Relationships:
- hasMany: LichHoc, LichThi
```

---

### **5. System Models (7 models)**

#### **Khoa** - Faculty

```php
Namespace: App\Models\System\Khoa

Fields:
- ten_khoa (unique)

Relationships:
- hasMany: Nganh, GiangVien
```

#### **KhoaHoc** - Course Year

```php
Namespace: App\Models\System\KhoaHoc

Fields:
- ten_khoa_hoc
- nam_bat_dau
- nam_ket_thuc

Relationships:
- hasMany: SinhVien
```

#### **HocKy** - Semester

```php
Namespace: App\Models\System\HocKy

Fields:
- ten_hoc_ky
- nam_bat_dau
- nam_ket_thuc
- ngay_bat_dau
- ngay_ket_thuc

Relationships:
- hasMany: LopHocPhan, BangDiem, HocPhi

Note: Unique (ten_hoc_ky, nam_bat_dau, nam_ket_thuc)
```

#### **DmTrinhDo** - Academic Degree

```php
Namespace: App\Models\System\DmTrinhDo

Fields:
- ten_trinh_do (unique)

Relationships:
- hasMany: GiangVien

Examples: Thạc sĩ, Tiến sĩ, Giáo sư...
```

#### **TrangThaiHocTap** - Study Status

```php
Namespace: App\Models\System\TrangThaiHocTap

Fields:
- ten_trang_thai (unique)

Relationships:
- hasMany: SinhVien

Examples: Đang học, Bảo lưu, Nghỉ học, Tốt nghiệp...
```

#### **ThongBao** - Notification

```php
Namespace: App\Models\System\ThongBao

Fields:
- tai_khoan_id
- tieu_de
- noi_dung
- loai (diem, lich_hoc, hoc_phi, dang_ky, he_thong)
- lien_ket
- da_doc

Relationships:
- belongsTo: TaiKhoan

Scopes:
- scopeUnread(), scopeRead(), scopeByType()

Methods:
- markAsRead(), markAsUnread()
```

#### **CauHinhHeThong** - System Config

```php
Namespace: App\Models\System\CauHinhHeThong

Fields:
- key (unique)
- value
- description

Static Methods:
- get($key, $default)
- set($key, $value, $description)
- has($key)
- remove($key)
- getHocPhiMotTinChi()
- getToiDaTinChiMoiKy()
- getThoiGianMoDangKy()
- getEmailSupport()

Usage:
CauHinhHeThong::set('hoc_phi_mot_tin_chi', 500000);
$fee = CauHinhHeThong::getHocPhiMotTinChi();
```

---

## 🔗 RELATIONSHIPS SUMMARY

### **Polymorphic:**

-   TaiKhoan → Admin | DaoTao | GiangVien | SinhVien (1-to-1 polymorphic)

### **Many-to-Many:**

-   TaiKhoan ↔ VaiTro (via tai_khoan_vai_tro)
-   VaiTro ↔ Quyen (via vai_tro_quyen)
-   MonHoc ↔ MonHoc (self-referencing via mon_hoc_tien_quyet)

### **One-to-Many:**

-   Khoa → Nganh, GiangVien
-   Nganh → ChuyenNganh, SinhVien
-   ChuyenNganh → SinhVien
-   KhoaHoc → SinhVien
-   HocKy → LopHocPhan, BangDiem, HocPhi
-   DmTrinhDo → GiangVien
-   TrangThaiHocTap → SinhVien
-   PhongHoc → LichHoc, LichThi

---

## ✅ CHECKLIST MODELS CHO ADMIN

### **Đã tạo (18 models):**

-   [x] Auth: TaiKhoan, VaiTro, Quyen (3)
-   [x] User: Admin, DaoTao, GiangVien, SinhVien (4)
-   [x] Academic: Nganh, ChuyenNganh, MonHoc (3)
-   [x] Schedule: PhongHoc (1)
-   [x] System: Khoa, KhoaHoc, HocKy, DmTrinhDo, TrangThaiHocTap, ThongBao, CauHinhHeThong (7)

### **Chưa cần (cho phần Admin):**

-   [ ] LopHocPhan, LichHoc, LichThi → Dành cho Đào tạo
-   [ ] DiemDanh, NhapDiem, BangDiem → Dành cho GV
-   [ ] DangKiMonHoc, HocPhi → Dành cho SV
-   [ ] AI Chatbot models → Feature nâng cao

---

## 🎯 SẴN SÀNG CHO DEVELOPMENT

**Models đã đủ để làm:**

1. ✅ Module Quản lý Danh mục (Khoa, Ngành, Chuyên ngành, Trình độ, Trạng thái)
2. ✅ Module Quản lý Thời gian (Khóa học, Học kỳ)
3. ✅ Module Quản lý Phòng học
4. ✅ Module Quản lý Vai trò & Quyền (RBAC)
5. ✅ Module Quản lý Tài khoản (Admin, Đào tạo, GV, SV)

**Next Steps:**

-   Setup Middleware & Authorization
-   Tạo Controllers cho các module
-   Tạo Views (CRUD interfaces)
-   Custom Sidebar Admin menu

# 🔔 Hệ thống Thông báo - S-MIS

## 📦 Tổng quan

Hệ thống thông báo đầy đủ cho Student Management Information System (S-MIS) bao gồm:

### ✅ **1. Thông báo Thủ công** (Admin tạo)

-   Admin có thể tạo và gửi thông báo cho:
    -   Tất cả người dùng
    -   Theo vai trò (admin, dao_tao, giang_vien, sinh_vien)
    -   Người dùng cụ thể
-   Live preview khi tạo thông báo
-   Quản lý CRUD đầy đủ
-   Xem chi tiết, xóa, xóa nhiều

### ✅ **2. Thông báo Tự động** (Hệ thống gửi)

-   Tự động gửi khi có sự kiện xảy ra
-   8+ loại thông báo được định sẵn
-   Dễ dàng tích hợp vào Controller
-   100% PHP (Laravel)

---

## 📂 Cấu trúc File

```
app/
├── Helpers/
│   └── NotificationHelper.php          # Helper gửi thông báo tự động
├── Http/Controllers/
│   ├── NotificationController.php      # Controller cho user
│   └── Admin/
│       ├── NotificationManagementController.php  # Controller admin
│       └── TestNotificationController.php        # Controller test
├── Models/HeThong/
│   └── ThongBao.php                    # Model thông báo

database/migrations/
└── 2025_10_20_023629_recreate_thong_bao_table.php

resources/views/
├── admin/
│   ├── notifications/
│   │   ├── index.blade.php             # Danh sách quản lý
│   │   ├── create.blade.php            # Form tạo thông báo
│   │   └── show.blade.php              # Chi tiết admin
│   └── test-notifications.blade.php    # Trang test thông báo
├── notifications/
│   ├── index.blade.php                 # Danh sách user
│   └── show.blade.php                  # Chi tiết user
└── layouts/blocks/
    └── header.blade.php                # Dropdown thông báo

routes/
└── web.php                             # Routes

AUTO_NOTIFICATION_GUIDE.md              # Hướng dẫn thông báo tự động
test_notification_helper.php            # Script test
```

---

## 🚀 Cách sử dụng

### **A. Thông báo Thủ công (Admin)**

1. **Truy cập:** `/admin/notifications`
2. **Tạo mới:** Click "Tạo thông báo mới"
3. **Điền form:**
    - Tiêu đề
    - Nội dung
    - Loại: Thông tin / Cảnh báo / Quan trọng
    - Gửi cho: Tất cả / Theo vai trò / Người cụ thể
    - Liên kết (optional)
4. **Preview:** Xem trước bên phải
5. **Gửi:** Click "Gửi thông báo"

### **B. Thông báo Tự động (Code)**

#### 1️⃣ Import Helper

```php
use App\Helpers\NotificationHelper;
```

#### 2️⃣ Gửi thông báo trong Controller

```php
// Khi thêm sinh viên vào lớp
NotificationHelper::notifyStudentAddedToClass(
    sinhVienId: $sinhVienId,
    tenLop: $lopHoc->ten_lop,
    tenMonHoc: $monHoc->ten_mon_hoc,
    lienKet: route('sinh-vien.lop-hoc.show', $lopHocId)
);

// Khi nhập điểm
NotificationHelper::notifyNewGrade(
    sinhVienId: $sinhVienId,
    tenMonHoc: $monHoc->ten_mon_hoc,
    lienKet: route('sinh-vien.diem.index')
);

// Cảnh báo điểm danh
NotificationHelper::notifyAttendanceWarning(
    sinhVienId: $sinhVienId,
    tenMonHoc: $monHoc->ten_mon_hoc,
    soLanVang: 4,
    gioiHan: 5
);
```

#### 3️⃣ Xem hướng dẫn đầy đủ

📄 **File:** `AUTO_NOTIFICATION_GUIDE.md`

---

## 🧪 Test Thông báo

### **Cách 1: Dùng UI Test** (Khuyến nghị)

1. Truy cập: `/admin/test-notifications`
2. Chọn loại thông báo muốn test
3. Nhập ID user
4. Click nút tương ứng
5. Kiểm tra thông báo tại `/notifications`

### **Cách 2: Dùng Tinker**

```bash
php artisan tinker
```

```php
use App\Helpers\NotificationHelper;

NotificationHelper::send(1, 'Test', 'Nội dung test', 'thong_tin');
```

### **Cách 3: Dùng Script**

```bash
php artisan tinker < test_notification_helper.php
```

---

## 📊 Database Schema

```sql
CREATE TABLE thong_bao (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_nhan_id BIGINT UNSIGNED NOT NULL,
    nguoi_tao_id BIGINT UNSIGNED NOT NULL,
    tieu_de VARCHAR(255) NOT NULL,
    noi_dung TEXT NOT NULL,
    loai ENUM('thong_tin', 'canh_bao', 'quan_trong') DEFAULT 'thong_tin',
    vai_tro_nhan ENUM('all', 'admin', 'dao_tao', 'giang_vien', 'sinh_vien', 'specific'),
    lien_ket VARCHAR(255) NULL,
    da_doc BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_nguoi_nhan (nguoi_nhan_id),
    INDEX idx_da_doc (da_doc),
    INDEX idx_created (created_at),

    FOREIGN KEY (nguoi_nhan_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (nguoi_tao_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## 🎯 Routes

### **Admin Routes** (Quản lý thông báo)

```
GET     /admin/notifications              - Danh sách
GET     /admin/notifications/create       - Form tạo mới
POST    /admin/notifications              - Lưu thông báo
GET     /admin/notifications/{id}         - Chi tiết
DELETE  /admin/notifications/{id}         - Xóa
POST    /admin/notifications/destroy-multiple - Xóa nhiều
GET     /admin/notifications/stats        - Thống kê (AJAX)
```

### **User Routes** (Xem thông báo)

```
GET     /notifications                    - Danh sách thông báo
GET     /notifications/{id}               - Chi tiết (tự động đánh dấu đã đọc)
POST    /notifications/{id}/read          - Đánh dấu đã đọc
POST    /notifications/mark-all-read      - Đánh dấu tất cả đã đọc
GET     /notifications/unread-count       - Số lượng chưa đọc (AJAX)
```

### **Test Routes** (Development)

```
GET     /admin/test-notifications         - Trang test
POST    /admin/test-notifications/send    - Gửi test
```

---

## 🎨 Loại thông báo & Màu sắc

| Loại         | Badge      | Icon | Màu               |
| ------------ | ---------- | ---- | ----------------- |
| `thong_tin`  | Thông tin  | ℹ️   | Xanh dương (info) |
| `canh_bao`   | Cảnh báo   | ⚠️   | Vàng (warning)    |
| `quan_trong` | Quan trọng | 🚫   | Đỏ (danger)       |

---

## 📖 API Functions

### **NotificationHelper Methods:**

```php
// Gửi thông báo đơn
send($nguoiNhanId, $tieuDe, $noiDung, $loai, $lienKet, $nguoiTaoId)

// Gửi nhiều người
sendToMultiple($nguoiNhanIds, $tieuDe, $noiDung, $loai, $lienKet)

// Gửi toàn lớp
sendToClass($lopHocId, $tieuDe, $noiDung, $loai, $lienKet)

// Thông báo định sẵn (8 loại)
notifyStudentAddedToClass($sinhVienId, $tenLop, $tenMonHoc, $lienKet)
notifyNewGrade($sinhVienId, $tenMonHoc, $lienKet)
notifyAttendanceWarning($sinhVienId, $tenMonHoc, $soLanVang, $gioiHan)
notifyAttendanceViolation($sinhVienId, $tenMonHoc, $soLanVang, $gioiHan)
notifyTeacherAssigned($giangVienId, $tenLop, $tenMonHoc, $lienKet)
notifyClassNearlyFull($daoTaoId, $tenLop, $soSinhVien, $sucChua)
notifyStudentViolation($daoTaoId, $tenSinhVien, $maSinhVien, $tenMonHoc)
notifyNewUser($adminId, $tenUser, $vaiTro)
```

---

## ✅ Features

-   [x] Quản lý thông báo CRUD (Admin)
-   [x] Gửi thông báo theo vai trò
-   [x] Gửi thông báo cho người cụ thể
-   [x] Live preview khi tạo
-   [x] Xóa đơn/xóa nhiều
-   [x] Xem chi tiết thông báo
-   [x] Tự động đánh dấu đã đọc khi xem
-   [x] Dropdown thông báo trong header
-   [x] Badge số lượng chưa đọc
-   [x] Đánh dấu tất cả đã đọc
-   [x] NotificationHelper (8+ thông báo tự động)
-   [x] Trang test thông báo với UI
-   [x] Logging tự động
-   [x] Responsive design
-   [x] Hướng dẫn sử dụng đầy đủ

---

## 🔄 Workflow

```
1. ADMIN TẠO THÔNG BÁO THỦ CÔNG
   ↓
   Admin → /admin/notifications/create → Điền form → Gửi
   ↓
   Thông báo lưu vào DB
   ↓
   User nhận được thông báo

2. HỆ THỐNG TỰ ĐỘNG GỬI
   ↓
   Sự kiện xảy ra (VD: Thêm SV vào lớp)
   ↓
   Controller gọi NotificationHelper
   ↓
   Thông báo lưu vào DB
   ↓
   User nhận được thông báo

3. USER XEM THÔNG BÁO
   ↓
   User → Header dropdown hoặc /notifications
   ↓
   Click vào thông báo → /notifications/{id}
   ↓
   Tự động đánh dấu đã đọc
   ↓
   Badge số lượng giảm
```

---

## 🐛 Debug & Logging

Tất cả thông báo được log tại: `storage/logs/laravel.log`

```
[INFO] NotificationHelper: Đã gửi thông báo #123 cho user #456
[WARNING] NotificationHelper: Người nhận không tồn tại (ID: 999)
[ERROR] NotificationHelper: Lỗi khi gửi thông báo - ...
```

---

## 📝 Changelog

### v1.1 (2025-10-20) - Thông báo Tự động

-   ✨ Thêm NotificationHelper.php
-   ✨ 8+ loại thông báo tự động
-   ✨ Trang test thông báo UI
-   ✨ Hướng dẫn sử dụng chi tiết
-   ✨ Logging tự động

### v1.0 (2025-10-20) - Thông báo Thủ công

-   ✨ Quản lý thông báo CRUD
-   ✨ Gửi theo vai trò/người cụ thể
-   ✨ Live preview
-   ✨ Xem chi tiết, đánh dấu đã đọc
-   ✨ Dropdown header

---

## 👥 Credits

-   **Developer:** S-MIS Team
-   **Framework:** Laravel 11.x
-   **UI:** Bootstrap 5
-   **Icons:** Bootstrap Icons

---

## 📚 Tài liệu tham khảo

-   `AUTO_NOTIFICATION_GUIDE.md` - Hướng dẫn thông báo tự động
-   `test_notification_helper.php` - Script test mẫu
-   `/admin/test-notifications` - UI test thông báo

---

**🎉 Hệ thống thông báo đã hoàn thành đầy đủ!**

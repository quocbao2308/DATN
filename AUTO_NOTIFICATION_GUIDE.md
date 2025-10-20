# 🔔 Hệ thống Thông báo Tự động

## 📋 Tổng quan

Hệ thống thông báo tự động sử dụng **NotificationHelper** để gửi thông báo PHP cho người dùng khi có các sự kiện xảy ra.

## 🎯 Các loại thông báo tự động

### 1. **Thông báo cho Sinh viên**

#### ✅ Khi được thêm vào lớp học

```php
use App\Helpers\NotificationHelper;

NotificationHelper::notifyStudentAddedToClass(
    sinhVienId: $sinhVienId,
    tenLop: 'Lớp CNTT K17',
    tenMonHoc: 'Lập trình Web',
    lienKet: route('sinh-vien.lop-hoc.show', $lopHocId) // optional
);
```

#### ✅ Khi có điểm mới

```php
NotificationHelper::notifyNewGrade(
    sinhVienId: $sinhVienId,
    tenMonHoc: 'Lập trình Web',
    lienKet: route('sinh-vien.diem.index') // optional
);
```

#### ⚠️ Cảnh báo điểm danh

```php
NotificationHelper::notifyAttendanceWarning(
    sinhVienId: $sinhVienId,
    tenMonHoc: 'Lập trình Web',
    soLanVang: 4,
    gioiHan: 5
);
```

#### 🚫 Vi phạm điểm danh

```php
NotificationHelper::notifyAttendanceViolation(
    sinhVienId: $sinhVienId,
    tenMonHoc: 'Lập trình Web',
    soLanVang: 6,
    gioiHan: 5
);
```

---

### 2. **Thông báo cho Giảng viên**

#### ✅ Khi được phân công lớp

```php
NotificationHelper::notifyTeacherAssigned(
    giangVienId: $giangVienId,
    tenLop: 'Lớp CNTT K17',
    tenMonHoc: 'Lập trình Web',
    lienKet: route('giang-vien.lop-hoc.show', $lopHocId)
);
```

---

### 3. **Thông báo cho Đào tạo**

#### ⚠️ Lớp gần đầy

```php
NotificationHelper::notifyClassNearlyFull(
    daoTaoId: $daoTaoId,
    tenLop: 'Lớp CNTT K17',
    soSinhVien: 45,
    sucChua: 50
);
```

#### 🚫 Sinh viên vi phạm điểm danh

```php
NotificationHelper::notifyStudentViolation(
    daoTaoId: $daoTaoId,
    tenSinhVien: 'Nguyễn Văn A',
    maSinhVien: 'PH12345',
    tenMonHoc: 'Lập trình Web'
);
```

---

### 4. **Thông báo cho Admin**

#### ✅ Tài khoản mới được tạo

```php
NotificationHelper::notifyNewUser(
    adminId: 1,
    tenUser: 'Nguyễn Văn B',
    vaiTro: 'Sinh viên'
);
```

---

## 🛠️ Các hàm Helper cơ bản

### Gửi thông báo cho 1 người

```php
NotificationHelper::send(
    nguoiNhanId: $userId,
    tieuDe: 'Tiêu đề thông báo',
    noiDung: 'Nội dung chi tiết...',
    loai: 'thong_tin', // thong_tin | canh_bao | quan_trong
    lienKet: 'https://example.com', // optional
    nguoiTaoId: Auth::id() // optional, mặc định: user hiện tại
);
```

### Gửi thông báo cho nhiều người

```php
NotificationHelper::sendToMultiple(
    nguoiNhanIds: [1, 2, 3, 4],
    tieuDe: 'Thông báo chung',
    noiDung: 'Nội dung...',
    loai: 'thong_tin',
    lienKet: null
);
```

### Gửi thông báo cho toàn bộ lớp

```php
NotificationHelper::sendToClass(
    lopHocId: $lopHocId,
    tieuDe: 'Thông báo lớp học',
    noiDung: 'Lịch học thay đổi...',
    loai: 'canh_bao',
    lienKet: route('lich-hoc.index')
);
```

---

## 📝 Ví dụ tích hợp vào Controller

### Ví dụ 1: Thêm sinh viên vào lớp

```php
// File: LopHocController.php

use App\Helpers\NotificationHelper;

public function addStudent(Request $request, $lopHocId)
{
    $lopHoc = LopHoc::findOrFail($lopHocId);
    $sinhVienId = $request->sinh_vien_id;

    // Thêm sinh viên vào lớp
    DB::table('lop_hoc_sinh_vien')->insert([
        'lop_hoc_id' => $lopHocId,
        'sinh_vien_id' => $sinhVienId,
        'created_at' => now(),
    ]);

    // ✅ GỬI THÔNG BÁO TỰ ĐỘNG
    NotificationHelper::notifyStudentAddedToClass(
        sinhVienId: $sinhVienId,
        tenLop: $lopHoc->ten_lop,
        tenMonHoc: $lopHoc->monHoc->ten_mon_hoc,
        lienKet: route('sinh-vien.lop-hoc.show', $lopHocId)
    );

    return redirect()->back()->with('success', 'Đã thêm sinh viên vào lớp');
}
```

### Ví dụ 2: Nhập điểm

```php
// File: DiemController.php

use App\Helpers\NotificationHelper;

public function store(Request $request)
{
    $diem = DiemThi::create($request->all());

    // ✅ GỬI THÔNG BÁO TỰ ĐỘNG
    NotificationHelper::notifyNewGrade(
        sinhVienId: $diem->sinh_vien_id,
        tenMonHoc: $diem->monHoc->ten_mon_hoc,
        lienKet: route('sinh-vien.diem.index')
    );

    return redirect()->back()->with('success', 'Đã nhập điểm');
}
```

### Ví dụ 3: Điểm danh

```php
// File: DiemDanhController.php

use App\Helpers\NotificationHelper;

public function store(Request $request)
{
    // Lưu điểm danh
    DiemDanh::create([
        'sinh_vien_id' => $sinhVienId,
        'buoi_hoc_id' => $buoiHocId,
        'trang_thai' => $request->trang_thai, // vang_co_phep, vang_khong_phep, co_mat
    ]);

    // Đếm số buổi vắng
    $soLanVang = DiemDanh::where('sinh_vien_id', $sinhVienId)
        ->where('lop_hoc_id', $lopHocId)
        ->whereIn('trang_thai', ['vang_co_phep', 'vang_khong_phep'])
        ->count();

    $gioiHan = 5; // Giới hạn vắng

    // ⚠️ CẢNH BÁO nếu gần vượt quá
    if ($soLanVang == $gioiHan - 1) {
        NotificationHelper::notifyAttendanceWarning(
            sinhVienId: $sinhVienId,
            tenMonHoc: $monHoc->ten_mon_hoc,
            soLanVang: $soLanVang,
            gioiHan: $gioiHan
        );
    }

    // 🚫 VI PHẠM nếu vượt quá
    if ($soLanVang >= $gioiHan) {
        NotificationHelper::notifyAttendanceViolation(
            sinhVienId: $sinhVienId,
            tenMonHoc: $monHoc->ten_mon_hoc,
            soLanVang: $soLanVang,
            gioiHan: $gioiHan
        );

        // Thông báo cho đào tạo
        $daoTaoUsers = User::whereHas('vaiTros', function($q) {
            $q->where('ten_vai_tro', 'dao_tao');
        })->pluck('id');

        foreach ($daoTaoUsers as $daoTaoId) {
            NotificationHelper::notifyStudentViolation(
                daoTaoId: $daoTaoId,
                tenSinhVien: $sinhVien->name,
                maSinhVien: $sinhVien->ma_sinh_vien,
                tenMonHoc: $monHoc->ten_mon_hoc
            );
        }
    }

    return redirect()->back();
}
```

---

## 🎨 Loại thông báo (Màu sắc)

-   `thong_tin` → Badge xanh (info) ℹ️
-   `canh_bao` → Badge vàng (warning) ⚠️
-   `quan_trong` → Badge đỏ (danger) 🚫

---

## ✅ Checklist triển khai

-   [x] Tạo NotificationHelper.php
-   [ ] Tích hợp vào LopHocController (thêm sinh viên)
-   [ ] Tích hợp vào DiemController (nhập điểm)
-   [ ] Tích hợp vào DiemDanhController (điểm danh)
-   [ ] Tích hợp vào UserController (tạo tài khoản)
-   [ ] Test các thông báo tự động

---

## 🐛 Debug & Log

Tất cả thông báo được log tự động:

```
Log::info("NotificationHelper: Đã gửi thông báo #123 cho user #456");
Log::warning("NotificationHelper: Người nhận không tồn tại (ID: 999)");
Log::error("NotificationHelper: Lỗi khi gửi thông báo - ...");
```

Kiểm tra log tại: `storage/logs/laravel.log`

---

## 📚 Tài liệu tham khảo

-   Model: `App\Models\HeThong\ThongBao`
-   Controller: `App\Http\Controllers\NotificationController`
-   Helper: `App\Helpers\NotificationHelper`

# Tài liệu: Quản lý Môn học

## ✅ Hoàn thành

### 1. Model và Database

**Model**: `app/Models/DaoTao/MonHoc.php`

-   ✅ Fillable: ma_mon, ten_mon, so_tin_chi, mo_ta, loai_mon, hinh_thuc_day, thoi_luong, so_buoi
-   ✅ Relationships:
    -   `monTienQuyets()`: Môn tiên quyết (self-referencing many-to-many)
    -   `monHocCanTienQuyet()`: Các môn yêu cầu môn này làm tiên quyết
    -   `lopHocPhans()`: Lớp học phần sử dụng môn này
    -   `chuongTrinhKhungs()`: Chương trình khung

**Database Table**: `mon_hoc`

-   id, ma_mon (unique), ten_mon, so_tin_chi, mo_ta, loai_mon
-   hinh_thuc_day (enum: offline/online/hybrid)
-   thoi_luong, so_buoi, timestamps, soft deletes

**Pivot Table**: `mon_hoc_tien_quyet`

-   mon_hoc_id, mon_tien_quyet_id

---

### 2. Controller

**MonHocController** (`app/Http/Controllers/DaoTao/MonHocController.php`)

#### Các Methods:

**index()**

-   Danh sách môn học với phân trang
-   Filter: search (mã/tên), loai_mon, hinh_thuc_day, so_tin_chi
-   Sắp xếp theo mã môn

**create()**

-   Hiển thị form thêm mới
-   Load danh sách tất cả môn học (để chọn môn tiên quyết)

**store()**

-   Validate dữ liệu đầu vào
-   Sử dụng `SystemConstants::TEACHING_MODES`
-   Tạo môn học mới
-   Gán môn tiên quyết (attach)
-   Transaction để đảm bảo tính toàn vẹn

**show($id)**

-   Hiển thị chi tiết môn học
-   Load with relationships: monTienQuyets, lopHocPhans, monHocCanTienQuyet
-   Thống kê số lượng

**edit($id)**

-   Form chỉnh sửa
-   Exclude môn hiện tại khỏi danh sách môn tiên quyết
-   Pre-fill dữ liệu cũ

**update($id)**

-   Validate với Rule::unique ignore current ID
-   Cập nhật thông tin môn học
-   Sync môn tiên quyết (thay vì attach/detach)
-   Transaction

**destroy($id)**

-   Kiểm tra môn học có lớp học phần không
-   Kiểm tra môn học có là môn tiên quyết của môn khác không
-   Detach tất cả môn tiên quyết
-   Soft delete môn học
-   Transaction

---

### 3. Views

#### index.blade.php

**Đường dẫn**: `resources/views/dao-tao/mon-hoc/index.blade.php`

**Tính năng**:

-   ✅ Danh sách môn học dạng table
-   ✅ Filter form: search, số tín chỉ, hình thức, loại môn
-   ✅ Badge màu cho hình thức: offline (primary), online (success), hybrid (info)
-   ✅ Hiển thị: mã môn, tên, tín chỉ, loại, hình thức, số buổi
-   ✅ Actions: Xem, Sửa, Xóa
-   ✅ Pagination
-   ✅ Nút "Thêm môn học"
-   ✅ Alert messages (success/error)

#### create.blade.php

**Đường dẫn**: `resources/views/dao-tao/mon-hoc/create.blade.php`

**Form fields**:

-   ✅ Mã môn học (required, unique)
-   ✅ Tên môn học (required)
-   ✅ Số tín chỉ (required, 1-10)
-   ✅ Loại môn (required, free text)
-   ✅ Hình thức dạy (required, dropdown từ SystemConstants)
-   ✅ Thời lượng (optional, giờ)
-   ✅ Số buổi học (optional)
-   ✅ Mô tả (optional, textarea)
-   ✅ Môn tiên quyết (optional, checkboxes với scroll)

**Features**:

-   ✅ Validation error messages
-   ✅ Old input retention
-   ✅ Checkboxes cho môn tiên quyết với badge tín chỉ
-   ✅ Scrollable area cho danh sách môn tiên quyết
-   ✅ Nút Lưu/Hủy

#### edit.blade.php

**Đường dẫn**: `resources/views/dao-tao/mon-hoc/edit.blade.php`

**Similar to create với**:

-   ✅ Pre-filled data từ database
-   ✅ Exclude môn hiện tại khỏi list môn tiên quyết
-   ✅ Checked state cho môn tiên quyết hiện tại
-   ✅ PUT method
-   ✅ Hiển thị tên môn đang sửa ở card header

#### show.blade.php

**Đường dẫn**: `resources/views/dao-tao/mon-hoc/show.blade.php`

**Layout**: 2 cột (4-8)

**Cột trái**:

-   ✅ Icon môn học
-   ✅ Mã môn học lớn
-   ✅ Nút Sửa/Xóa
-   ✅ Card thống kê:
    -   Số lớp học phần
    -   Số môn tiên quyết
    -   Số môn yêu cầu môn này

**Cột phải**:

-   ✅ Card thông tin môn học (table)
-   ✅ Card môn tiên quyết (nếu có)
    -   Grid 2 cột
    -   Border box cho mỗi môn
    -   Badge tín chỉ
-   ✅ Card "Là môn tiên quyết của" (nếu có)
    -   Tương tự môn tiên quyết
-   ✅ Card lớp học phần (table)
    -   Mã lớp, học kỳ, sức chứa, trạng thái
    -   Link xem chi tiết
    -   Badge màu cho trạng thái

---

### 4. Routes

**File**: `routes/web.php`

```php
Route::prefix('dao-tao')->name('dao-tao.')->middleware(['auth'])->group(function () {
    // Quản lý Môn học
    Route::resource('mon-hoc', \App\Http\Controllers\DaoTao\MonHocController::class);
});
```

**Danh sách routes**:

-   GET `/dao-tao/mon-hoc` → index
-   GET `/dao-tao/mon-hoc/create` → create
-   POST `/dao-tao/mon-hoc` → store
-   GET `/dao-tao/mon-hoc/{id}` → show
-   GET `/dao-tao/mon-hoc/{id}/edit` → edit
-   PUT `/dao-tao/mon-hoc/{id}` → update
-   DELETE `/dao-tao/mon-hoc/{id}` → destroy

---

### 5. Validation Rules

**Mã môn học**:

-   Required, string, max:50
-   Unique (ignore khi update)

**Tên môn học**:

-   Required, string, max:255

**Số tín chỉ**:

-   Required, integer, min:1, max:10

**Loại môn**:

-   Required, string, max:100

**Hình thức dạy**:

-   Required, in:offline,online,hybrid (từ SystemConstants)

**Thời lượng**:

-   Nullable, integer, min:0

**Số buổi**:

-   Nullable, integer, min:0

**Mô tả**:

-   Nullable, string, max:1000

**Môn tiên quyết**:

-   Nullable, array
-   Each: exists:mon_hoc,id

---

### 6. Constants Integration

**SystemConstants::TEACHING_MODES**:

```php
[
    'offline' => 'Offline',
    'online' => 'Online',
    'hybrid' => 'Hybrid',
]
```

**Sử dụng trong**:

-   Controller validation: `'in:' . implode(',', array_keys(SystemConstants::TEACHING_MODES))`
-   View dropdown: `@foreach(SystemConstants::TEACHING_MODES as $key => $label)`
-   View badges: `@switch($monHoc->hinh_thuc_day)`

---

### 7. Business Logic

#### Xóa môn học:

1. ❌ Không cho xóa nếu có lớp học phần
    - Error: "Không thể xóa môn học đang có lớp học phần"
2. ❌ Không cho xóa nếu là môn tiên quyết của môn khác
    - Error: "Không thể xóa môn học đang là môn tiên quyết của môn khác"
3. ✅ Xóa các môn tiên quyết của môn này trước
4. ✅ Soft delete môn học

#### Môn tiên quyết:

-   Không thể chọn chính môn đó làm môn tiên quyết (excluded trong list)
-   Có thể chọn nhiều môn tiên quyết
-   Hiển thị 2 chiều: môn A tiên quyết của B, và B yêu cầu A

---

### 8. UI/UX Features

**Color Scheme**:

-   Offline: Primary (blue)
-   Online: Success (green)
-   Hybrid: Info (cyan)
-   Tín chỉ badge: Info

**Icons**:

-   Môn học: `bi-book`
-   Thống kê: `bi-journal-text`, `bi-arrow-right-circle`, `bi-arrow-left-circle`
-   Actions: `bi-eye`, `bi-pencil`, `bi-trash`

**Responsive**:

-   Bootstrap grid system
-   Mobile-friendly tables
-   Responsive breadcrumbs

**User Feedback**:

-   Success/Error alerts
-   Confirm dialog khi xóa
-   Validation error messages
-   Empty state messages

---

## 📊 Mapping với yêu cầu ĐÀO TẠO

Theo ảnh bạn gửi, **Quản lý môn học (5 chức năng)**:

1. ✅ Xem danh sách môn học → **index()**
2. ✅ Thêm môn học → **create(), store()**
3. ✅ Sửa môn học → **edit(), update()**
4. ✅ Xóa môn học → **destroy()**
5. ✅ Chi tiết môn học → **show()**

**Bonus**: Quản lý môn tiên quyết (tích hợp trong create/edit)

---

## 🚀 Hướng dẫn sử dụng

### Thêm môn học mới:

1. Vào `/dao-tao/mon-hoc`
2. Click "Thêm môn học"
3. Điền thông tin (mã, tên, tín chỉ, loại, hình thức)
4. Chọn môn tiên quyết (nếu có)
5. Click "Lưu môn học"

### Xem chi tiết:

-   Click icon mắt (eye) ở cột hành động
-   Xem thông tin đầy đủ, môn tiên quyết, lớp học phần

### Sửa môn học:

-   Click icon bút (pencil)
-   Cập nhật thông tin
-   Thêm/bỏ môn tiên quyết
-   Click "Cập nhật"

### Xóa môn học:

-   Click icon thùng rác (trash)
-   Confirm xóa
-   Chỉ xóa được nếu:
    -   Không có lớp học phần
    -   Không là môn tiên quyết của môn khác

---

## ✅ Checklist

-   [x] Tạo MonHocController với 7 methods CRUD
-   [x] Validation với SystemConstants
-   [x] View index với filter và pagination
-   [x] View create với môn tiên quyết
-   [x] View edit với pre-fill data
-   [x] View show với statistics và relationships
-   [x] Resource routes trong web.php
-   [x] Business logic xóa môn học
-   [x] UI/UX với Bootstrap 5
-   [x] Responsive design
-   [x] Alert messages
-   [x] Clear cache

---

## 🎯 Kết quả

✅ **Hoàn thành 100%** chức năng Quản lý môn học theo yêu cầu của module Đào tạo.

Hệ thống giờ có thể:

-   Quản lý đầy đủ thông tin môn học
-   Thiết lập môn tiên quyết (prerequisite)
-   Theo dõi môn học được sử dụng ở đâu
-   Kiểm tra ràng buộc trước khi xóa
-   Tích hợp với lớp học phần và chương trình khung

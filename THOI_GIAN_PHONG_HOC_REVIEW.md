# 🔍 KIỂM TRA CODE QUẢN LÝ THỜI GIAN & PHÒNG HỌC

**Ngày kiểm tra:** October 11, 2025  
**Phạm vi:** KhoaHocController, HocKyController, PhongHocController

---

## 📊 TỔNG QUAN

| Controller             | Trạng thái | Vấn đề Critical | Vấn đề Medium | Vấn đề Logic | Tổng  |
| ---------------------- | ---------- | --------------- | ------------- | ------------ | ----- |
| **KhoaHocController**  | ⚠️         | 1               | 1             | 0            | **2** |
| **HocKyController**    | 🚨         | 3               | 0             | 1            | **4** |
| **PhongHocController** | ✅         | 0               | 0             | 0            | **0** |

---

## 🚨 1. KHOA_HOC - 2 VẤN ĐỀ

### **A. Model thiếu field `mo_ta`** (Critical)

**File:** `app/Models/HeThong/KhoaHoc.php` - Line 14

**Vấn đề:**

```php
// ❌ Model thiếu field mo_ta
protected $fillable = [
    'ten_khoa_hoc',
    'nam_bat_dau',
    'nam_ket_thuc',
    // THIẾU: 'mo_ta'
];
```

**Trong khi Controller validate:**

```php
// ✅ Controller có validate mo_ta
$validated = $request->validate([
    'ten_khoa_hoc' => '...',
    'nam_bat_dau' => '...',
    'nam_ket_thuc' => '...',
    'mo_ta' => 'nullable|string|max:500',  // ← Có validate
]);
```

**⚠️ HẬU QUẢ:**

-   ❌ Field `mo_ta` **KHÔNG LƯU** vào database
-   ❌ Form có input nhưng data bị mất

**✅ FIX:**

```php
protected $fillable = [
    'ten_khoa_hoc',
    'nam_bat_dau',
    'nam_ket_thuc',
    'mo_ta',  // THÊM
];
```

---

### **B. ERD thiếu field `mo_ta`** (Medium)

**File:** `database.dbml` - Line 279

**ERD hiện tại:**

```dbml
Table khoa_hoc {
  id int [pk]
  ten_khoa_hoc varchar [not null]
  nam_bat_dau int
  nam_ket_thuc int
  // THIẾU: mo_ta text
}
```

**✅ NÊN THÊM:**

```dbml
Table khoa_hoc {
  id int [pk]
  ten_khoa_hoc varchar [not null]
  nam_bat_dau int
  nam_ket_thuc int
  mo_ta text [note: 'Mô tả khóa học']
}
```

---

## 🚨 2. HOC_KY - 4 VẤN ĐỀ NGHIÊM TRỌNG

### **A. Controller validate sai tên trường** (Critical)

**File:** `HocKyController.php` - Line 38

**Vấn đề:**

```php
// ❌ Controller validate 'hoc_ky' (INTEGER)
$validated = $request->validate([
    'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
    'hoc_ky' => [  // ← SAI TÊN FIELD
        'required',
        'integer',
        'min:1',
        'max:10',
        Rule::unique('hoc_ky')->where(...)
    ],
]);
```

**Nhưng ERD định nghĩa:**

```dbml
Table hoc_ky {
  id int [pk]
  ten_hoc_ky varchar [not null]  // ← TÊN ĐÚNG
  nam_bat_dau int
  nam_ket_thuc int
  ngay_bat_dau date
  ngay_ket_thuc date
}
```

**Model cũng dùng tên khác:**

```php
protected $fillable = [
    'ten_hoc_ky',  // ← TÊN ĐÚNG
    'nam_bat_dau',
    'nam_ket_thuc',
    'ngay_bat_dau',
    'ngay_ket_thuc',
];
```

**⚠️ HẬU QUẢ:**

-   🚨 **DATA KHÔNG BAO GIỜ LƯU** vào field `ten_hoc_ky`
-   🚨 Form submit nhưng **field bị NULL**
-   🚨 Unique validation **KHÔNG HOẠT ĐỘNG**

**✅ FIX:**

```php
// Sửa tất cả 'hoc_ky' → 'ten_hoc_ky'
$validated = $request->validate([
    'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
    'ten_hoc_ky' => [  // ← SỬA
        'required',
        'string',  // ← ĐỔI THÀNH STRING
        'max:100',
        Rule::unique('hoc_ky')->where(function ($query) use ($request) {
            return $query->where('khoa_hoc_id', $request->khoa_hoc_id);
        })
    ],
    'ngay_bat_dau' => 'required|date',
    'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
    'mo_ta' => 'nullable|string|max:500',
]);
```

---

### **B. Model thiếu field `khoa_hoc_id`** (Critical)

**File:** `app/Models/HeThong/HocKy.php` - Line 14

**Vấn đề:**

```php
// ❌ Thiếu khoa_hoc_id
protected $fillable = [
    'ten_hoc_ky',
    'nam_bat_dau',
    'nam_ket_thuc',
    'ngay_bat_dau',
    'ngay_ket_thuc',
    // THIẾU: 'khoa_hoc_id'
];
```

**Controller validate có:**

```php
'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
```

**⚠️ HẬU QUẬ:**

-   🚨 **Không thể gán học kỳ cho khóa học**
-   🚨 Foreign key **KHÔNG LƯU**

**✅ FIX:**

```php
protected $fillable = [
    'khoa_hoc_id',  // THÊM
    'ten_hoc_ky',
    'nam_bat_dau',
    'nam_ket_thuc',
    'ngay_bat_dau',
    'ngay_ket_thuc',
    'mo_ta',  // NÊN THÊM
];
```

---

### **C. Model thiếu field `mo_ta`** (Critical)

**Tương tự KhoaHoc, HocKy cũng thiếu `mo_ta` trong Model**

---

### **D. Model thiếu relationship `khoaHoc`** (Medium)

**File:** `app/Models/HeThong/HocKy.php`

**Vấn đề:**

```php
// ❌ THIẾU relationship với KhoaHoc
public function lopHocPhans() { ... }
public function bangDiems() { ... }
public function hocPhis() { ... }
// THIẾU: public function khoaHoc()
```

**Controller có dùng:**

```php
$hocKys = HocKy::with('khoaHoc')  // ← Dùng relationship
    ->orderBy('khoa_hoc_id', 'desc')
    ->paginate(15);
```

**⚠️ HẬU QUẬ:**

-   🚨 **Query error** khi load relationship
-   🚨 View không hiển thị được tên khóa học

**✅ FIX:**

```php
public function khoaHoc()
{
    return $this->belongsTo(KhoaHoc::class, 'khoa_hoc_id');
}
```

---

### **E. Controller `destroy()` thiếu validation** (Logic issue)

**File:** `HocKyController.php` - Line 121

**Vấn đề:**

```php
// ❌ XÓA TRỰC TIẾP KHÔNG KIỂM TRA
public function destroy(string $id)
{
    $hocKy = HocKy::findOrFail($id);
    $hocKy->delete();  // Nguy hiểm!

    return redirect()->route('admin.hoc-ky.index')
        ->with('success', 'Xóa học kỳ thành công');
}
```

**⚠️ HẬU QUẬ:**

-   ❌ Xóa học kỳ đang có lớp học phần
-   ❌ Xóa học kỳ đang có bảng điểm
-   ❌ Xóa học kỳ đang có học phí
-   🚨 **Data orphan hoặc foreign key error**

**✅ FIX:**

```php
public function destroy(string $id)
{
    $hocKy = HocKy::findOrFail($id);

    // Kiểm tra có lớp học phần
    if ($hocKy->lopHocPhans()->count() > 0) {
        return redirect()->route('admin.hoc-ky.index')
            ->with('error', 'Không thể xóa học kỳ này vì đang có lớp học phần!');
    }

    // Kiểm tra có bảng điểm
    if ($hocKy->bangDiems()->count() > 0) {
        return redirect()->route('admin.hoc-ky.index')
            ->with('error', 'Không thể xóa học kỳ này vì đang có bảng điểm!');
    }

    // Kiểm tra có học phí
    if ($hocKy->hocPhis()->count() > 0) {
        return redirect()->route('admin.hoc-ky.index')
            ->with('error', 'Không thể xóa học kỳ này vì đang có học phí!');
    }

    $hocKy->delete();

    return redirect()->route('admin.hoc-ky.index')
        ->with('success', 'Xóa học kỳ thành công');
}
```

---

## ✅ 3. PHONG_HOC - HOÀN HẢO!

**File:** `PhongHocController.php`

**Đánh giá:**

-   ✅ Model có đủ 7 fields
-   ✅ Migration đã chạy xong
-   ✅ Validation đầy đủ
-   ✅ Delete có check relationship
-   ✅ ERD đã cập nhật

**Không có vấn đề gì!** 🎉

---

## 📋 BẢNG TỔNG HỢP VẤN ĐỀ

| Module       | Vấn đề                    | Mức độ      | File                | Fix Priority |
| ------------ | ------------------------- | ----------- | ------------------- | ------------ |
| **KhoaHoc**  | Model thiếu `mo_ta`       | 🚨 Critical | KhoaHoc.php         | **HIGH**     |
| **KhoaHoc**  | ERD thiếu `mo_ta`         | ⚠️ Medium   | database.dbml       | **MEDIUM**   |
| **HocKy**    | Controller sai tên field  | 🚨 Critical | HocKyController.php | **CRITICAL** |
| **HocKy**    | Model thiếu `khoa_hoc_id` | 🚨 Critical | HocKy.php           | **CRITICAL** |
| **HocKy**    | Model thiếu `mo_ta`       | 🚨 Critical | HocKy.php           | **HIGH**     |
| **HocKy**    | Model thiếu relationship  | ⚠️ Medium   | HocKy.php           | **HIGH**     |
| **HocKy**    | Delete không check        | ⚠️ Logic    | HocKyController.php | **HIGH**     |
| **PhongHoc** | Không có vấn đề           | ✅ OK       | -                   | -            |

---

## ✅ DANH SÁCH CÔNG VIỆC CẦN LÀM

### **Priority 1 (CRITICAL - Làm ngay!):**

#### **1. Fix HocKyController - Đổi tên field**

```php
// File: HocKyController.php
// Đổi TẤT CẢ 'hoc_ky' → 'ten_hoc_ky'
// Đổi validation từ integer → string
```

#### **2. Fix HocKy Model - Thêm 3 fields**

```php
// File: HocKy.php
protected $fillable = [
    'khoa_hoc_id',  // THÊM
    'ten_hoc_ky',
    'nam_bat_dau',
    'nam_ket_thuc',
    'ngay_bat_dau',
    'ngay_ket_thuc',
    'mo_ta',  // THÊM
];
```

#### **3. Fix HocKy Model - Thêm relationship**

```php
// File: HocKy.php
public function khoaHoc()
{
    return $this->belongsTo(KhoaHoc::class, 'khoa_hoc_id');
}
```

---

### **Priority 2 (HIGH - Làm hôm nay):**

#### **4. Fix KhoaHoc Model - Thêm field**

```php
// File: KhoaHoc.php
protected $fillable = [
    'ten_khoa_hoc',
    'nam_bat_dau',
    'nam_ket_thuc',
    'mo_ta',  // THÊM
];
```

#### **5. Fix HocKyController destroy()**

-   Thêm check `lopHocPhans()->count()`
-   Thêm check `bangDiems()->count()`
-   Thêm check `hocPhis()->count()`

---

### **Priority 3 (MEDIUM - Làm trong tuần):**

#### **6. Cập nhật ERD**

```dbml
// Thêm mo_ta vào khoa_hoc
// Cập nhật hoc_ky structure
```

---

## 🎯 ƯỚC TÍNH THỜI GIAN

| Task                                      | Time       | Difficulty |
| ----------------------------------------- | ---------- | ---------- |
| Fix HocKyController field name            | 10 phút    | Easy       |
| Fix HocKy Model (3 fields + relationship) | 5 phút     | Easy       |
| Fix KhoaHoc Model (1 field)               | 2 phút     | Easy       |
| Fix HocKy destroy()                       | 15 phút    | Medium     |
| Cập nhật ERD                              | 5 phút     | Easy       |
| Test lại                                  | 20 phút    | Easy       |
| **TỔNG**                                  | **~1 giờ** | -          |

---

## 🔥 VẤN ĐỀ NGHIÊM TRỌNG NHẤT

### **HocKyController validate SAI TÊN FIELD:**

**Hiện tại:**

```php
'hoc_ky' => [  // ← SAI!
    'required',
    'integer',  // ← SAI KIỂU!
```

**Phải là:**

```php
'ten_hoc_ky' => [  // ← ĐÚNG
    'required',
    'string',  // ← ĐÚNG KIỂU
    'max:100',
```

**→ Đây là lỗi CRITICAL khiến data KHÔNG LƯU được!**

---

## 📊 SO SÁNH CONTROLLER vs MODEL vs ERD

### **KHOA_HOC:**

| Field        | Controller | Model | ERD | Status    |
| ------------ | ---------- | ----- | --- | --------- |
| ten_khoa_hoc | ✅         | ✅    | ✅  | OK        |
| nam_bat_dau  | ✅         | ✅    | ✅  | OK        |
| nam_ket_thuc | ✅         | ✅    | ✅  | OK        |
| mo_ta        | ✅         | ❌    | ❌  | **THIẾU** |

### **HOC_KY:**

| Field               | Controller | Model | ERD | Status      |
| ------------------- | ---------- | ----- | --- | ----------- |
| khoa_hoc_id         | ✅         | ❌    | ✅  | **THIẾU**   |
| ten_hoc_ky / hoc_ky | ❌         | ✅    | ✅  | **SAI TÊN** |
| nam_bat_dau         | ✅         | ✅    | ✅  | OK          |
| nam_ket_thuc        | ✅         | ✅    | ✅  | OK          |
| ngay_bat_dau        | ✅         | ✅    | ✅  | OK          |
| ngay_ket_thuc       | ✅         | ✅    | ✅  | OK          |
| mo_ta               | ✅         | ❌    | ❌  | **THIẾU**   |

### **PHONG_HOC:**

| Field      | Controller | Model | ERD | Status |
| ---------- | ---------- | ----- | --- | ------ |
| ma_phong   | ✅         | ✅    | ✅  | OK     |
| ten_phong  | ✅         | ✅    | ✅  | OK     |
| suc_chua   | ✅         | ✅    | ✅  | OK     |
| vi_tri     | ✅         | ✅    | ✅  | OK     |
| loai_phong | ✅         | ✅    | ✅  | OK     |
| trang_thai | ✅         | ✅    | ✅  | OK     |
| mo_ta      | ✅         | ✅    | ✅  | OK     |

---

## 🎯 KẾT LUẬN

### **KHOA_HOC:** ⚠️ **Thiếu nhẹ**

-   Chỉ thiếu 1 field `mo_ta` trong Model và ERD
-   Ít ảnh hưởng, chỉ mất mô tả

### **HOC_KY:** 🚨 **VẤN ĐỀ NGHIÊM TRỌNG**

-   Controller validate **SAI TÊN FIELD** → Data không lưu
-   Model thiếu **2 fields quan trọng** (`khoa_hoc_id`, `mo_ta`)
-   Model thiếu **relationship** → Query error
-   Delete không check → Risk data integrity

### **PHONG_HOC:** ✅ **HOÀN HẢO**

-   Đã fix xong tất cả từ lần trước

---

**© 2025 S-MIS Code Review**

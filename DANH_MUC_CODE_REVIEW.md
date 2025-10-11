# 🔍 KIỂM TRA CODE QUẢN LÝ DANH MỤC

**Ngày kiểm tra:** October 11, 2025  
**Phạm vi:** Controllers quản lý Khoa, Ngành, Chuyên ngành, Phòng học

---

## 📊 TỔNG QUAN

| Controller                | Status | Vấn đề nghiêm trọng | Vấn đề nhẹ | Tổng vấn đề  |
| ------------------------- | ------ | ------------------- | ---------- | ------------ |
| **KhoaController**        | ⚠️     | 0                   | 1          | 1            |
| **NganhController**       | ⚠️     | 1                   | 0          | 1            |
| **ChuyenNganhController** | ⚠️     | 1                   | 0          | 1            |
| **PhongHocController**    | 🚨     | 3                   | 0          | **3**        |
| **MonHocController**      | ❌     | -                   | -          | **CHƯA TẠO** |

---

## 🚨 1. PHONG_HOC - VẤN ĐỀ NGHIÊM TRỌNG

### **A. Thiếu trường dữ liệu trong Model**

**File:** `app/Models/LichHoc/PhongHoc.php`

**Vấn đề:**

```php
// ❌ SAI - Model chỉ có 3 fields
protected $fillable = [
    'ma_phong',
    'suc_chua',
    'vi_tri',
];
```

**Trong khi Controller validate 7 fields:**

```php
// ✅ Controller validate đúng
$validated = $request->validate([
    'ma_phong' => 'required|string|max:50|unique:phong_hoc,ma_phong',
    'ten_phong' => 'required|string|max:255',  // ❌ THIẾU trong Model
    'suc_chua' => 'required|integer|min:1|max:1000',
    'vi_tri' => 'nullable|string|max:255',
    'loai_phong' => 'nullable|in:...',  // ❌ THIẾU trong Model
    'trang_thai' => 'required|in:...',  // ❌ THIẾU trong Model
    'mo_ta' => 'nullable|string|max:500',  // ❌ THIẾU trong Model
]);
```

**Trong ERD chỉ có 3 fields:**

```dbml
Table phong_hoc {
  id int [pk]
  ma_phong varchar [not null, unique]
  suc_chua int
  vi_tri varchar
}
```

**⚠️ HẬU QUẢ:**

-   ❌ Data `ten_phong`, `loai_phong`, `trang_thai`, `mo_ta` **KHÔNG LƯU VÀO DATABASE**
-   ❌ Form hiển thị nhưng data bị mất sau khi submit
-   ❌ Validation pass nhưng insert/update fail im lặng

---

### **B. Thiếu migration cho các trường mới**

**Vấn đề:** Migration `create_phong_hoc` chỉ tạo 3 cột:

```php
// ❌ Migration thiếu 4 cột
Schema::create('phong_hoc', function (Blueprint $table) {
    $table->id();
    $table->string('ma_phong')->unique();
    $table->integer('suc_chua');
    $table->string('vi_tri')->nullable();
    $table->timestamps();
});
```

**Cần thêm:**

```php
$table->string('ten_phong');  // THIẾU
$table->string('loai_phong')->nullable();  // THIẾU
$table->string('trang_thai')->default('Hoạt động');  // THIẾU
$table->text('mo_ta')->nullable();  // THIẾU
```

---

### **C. Thiếu validation cho delete**

**File:** `PhongHocController.php` - Line 135

**Vấn đề:**

```php
// ❌ XÓA TRỰC TIẾP KHÔNG KIỂM TRA
public function destroy(string $id)
{
    $phongHoc = PhongHoc::findOrFail($id);
    $phongHoc->delete();  // Nguy hiểm!

    return redirect()->route('admin.phong-hoc.index')
        ->with('success', 'Xóa phòng học thành công');
}
```

**⚠️ HẬU QUẢ:**

-   ❌ Xóa phòng đang có lịch học → Lỗi foreign key hoặc data orphan
-   ❌ Xóa phòng đang có lịch thi → Mất dữ liệu quan trọng

**✅ NÊN SỬA:**

```php
public function destroy(string $id)
{
    $phongHoc = PhongHoc::findOrFail($id);

    // Kiểm tra có lịch học không
    if ($phongHoc->lichHocs()->count() > 0) {
        return redirect()
            ->route('admin.phong-hoc.index')
            ->with('error', 'Không thể xóa phòng này vì đang có lịch học!');
    }

    // Kiểm tra có lịch thi không
    if ($phongHoc->lichThis()->count() > 0) {
        return redirect()
            ->route('admin.phong-hoc.index')
            ->with('error', 'Không thể xóa phòng này vì đang có lịch thi!');
    }

    $phongHoc->delete();

    return redirect()->route('admin.phong-hoc.index')
        ->with('success', 'Xóa phòng học thành công');
}
```

---

## ⚠️ 2. NGANH - VẤN ĐỀ LOGIC

### **A. Thiếu unique constraint cho tên ngành**

**File:** `NganhController.php` - Line 38

**Vấn đề:**

```php
// ❌ CHỈ VALIDATE STRING
$validated = $request->validate([
    'ten_nganh' => 'required|string|max:255',  // THIẾU unique
    'khoa_id' => 'required|exists:khoa,id',
]);
```

**Trong ERD có unique constraint:**

```dbml
Table nganh {
  id int [pk]
  ten_nganh varchar [not null]
  khoa_id int [ref: > khoa.id]
  indexes { (ten_nganh, khoa_id) [unique] }  // ← Unique theo KHOA
}
```

**⚠️ HẬU QUẢ:**

-   ❌ Có thể tạo 2 ngành trùng tên trong cùng 1 khoa
-   ❌ Database level sẽ reject nhưng Laravel không báo lỗi rõ ràng

**✅ NÊN SỬA:**

```php
$validated = $request->validate([
    'ten_nganh' => [
        'required',
        'string',
        'max:255',
        Rule::unique('nganh')->where(function ($query) use ($request) {
            return $query->where('khoa_id', $request->khoa_id);
        }),
    ],
    'khoa_id' => 'required|exists:khoa,id',
], [
    'ten_nganh.unique' => 'Tên ngành đã tồn tại trong khoa này!',
]);
```

---

## ⚠️ 3. CHUYEN_NGANH - VẤN ĐỀ TƯƠNG TỰ

### **A. Thiếu unique constraint**

**File:** `ChuyenNganhController.php` - Line 38

**Vấn đề:**

```php
// ❌ THIẾU UNIQUE
$validated = $request->validate([
    'ten_chuyen_nganh' => 'required|string|max:255',  // THIẾU unique
    'nganh_id' => 'required|exists:nganh,id',
]);
```

**ERD:**

```dbml
Table chuyen_nganh {
  id int [pk]
  ten_chuyen_nganh varchar [not null]
  nganh_id int [ref: > nganh.id]
  indexes { (ten_chuyen_nganh, nganh_id) [unique] }  // ← Unique theo NGÀNH
}
```

**✅ NÊN SỬA:**

```php
$validated = $request->validate([
    'ten_chuyen_nganh' => [
        'required',
        'string',
        'max:255',
        Rule::unique('chuyen_nganh')->where(function ($query) use ($request) {
            return $query->where('nganh_id', $request->nganh_id);
        }),
    ],
    'nganh_id' => 'required|exists:nganh,id',
], [
    'ten_chuyen_nganh.unique' => 'Tên chuyên ngành đã tồn tại trong ngành này!',
]);
```

---

## ℹ️ 4. KHOA - VẤN ĐỀ NHỎ

### **A. Có thể bổ sung soft delete**

**File:** `KhoaController.php`

**Hiện tại:**

```php
// ✅ ĐÃ KIỂM TRA relationship
if ($khoa->nganhs()->count() > 0) { ... }
if ($khoa->giangViens()->count() > 0) { ... }
$khoa->delete();  // Hard delete
```

**Gợi ý:** Nên dùng **soft delete** thay vì hard delete để:

-   ✅ Giữ lại lịch sử
-   ✅ Có thể khôi phục
-   ✅ Báo cáo vẫn chính xác

---

## ❌ 5. MON_HOC - CHƯA CÓ CONTROLLER

**Vấn đề nghiêm trọng:** Chưa có `MonHocController` trong khi ERD có bảng `mon_hoc`

**ERD:**

```dbml
Table mon_hoc {
  id int [pk]
  ma_mon varchar [not null, unique]
  ten_mon varchar [not null]
  so_tin_chi int
  mo_ta text
  loai_mon varchar
  hinh_thuc_day hinh_thuc_enum
  thoi_luong int
  so_buoi int
}

Table mon_hoc_tien_quyet {
  mon_hoc_id int [ref: > mon_hoc.id]
  mon_tien_quyet_id int [ref: > mon_hoc.id]
  indexes { (mon_hoc_id, mon_tien_quyet_id) [pk] }
}
```

**Cần tạo:**

-   ❌ `MonHocController.php`
-   ❌ Views (index, create, edit, show)
-   ❌ Routes
-   ❌ Model (nếu chưa có)
-   ❌ Validation logic cho môn tiên quyết

---

## 📋 BẢNG TỔNG HỢP VẤN ĐỀ

| Controller                | Vấn đề                    | Mức độ      | Ảnh hưởng       | Fix Priority |
| ------------------------- | ------------------------- | ----------- | --------------- | ------------ |
| **PhongHocController**    | Model thiếu 4 fields      | 🚨 Critical | Data loss       | **HIGH**     |
| **PhongHocController**    | Migration thiếu 4 columns | 🚨 Critical | Schema mismatch | **HIGH**     |
| **PhongHocController**    | Thiếu check delete        | 🚨 Critical | Data integrity  | **HIGH**     |
| **NganhController**       | Thiếu unique validation   | ⚠️ Medium   | Duplicate data  | **MEDIUM**   |
| **ChuyenNganhController** | Thiếu unique validation   | ⚠️ Medium   | Duplicate data  | **MEDIUM**   |
| **KhoaController**        | Hard delete               | ℹ️ Low      | History loss    | **LOW**      |
| **MonHocController**      | Chưa tồn tại              | ❌ Missing  | Cannot manage   | **HIGH**     |

---

## ✅ DANH SÁCH CÔNG VIỆC CẦN LÀM

### **Priority 1 (Critical - Làm ngay):**

#### **1. Fix PhongHoc Model**

```php
// File: app/Models/LichHoc/PhongHoc.php
protected $fillable = [
    'ma_phong',
    'ten_phong',      // THÊM
    'suc_chua',
    'vi_tri',
    'loai_phong',     // THÊM
    'trang_thai',     // THÊM
    'mo_ta',          // THÊM
];
```

#### **2. Tạo Migration mới cho PhongHoc**

```bash
php artisan make:migration add_fields_to_phong_hoc_table
```

```php
public function up()
{
    Schema::table('phong_hoc', function (Blueprint $table) {
        $table->string('ten_phong')->after('ma_phong');
        $table->string('loai_phong')->nullable()->after('vi_tri');
        $table->string('trang_thai')->default('Hoạt động')->after('loai_phong');
        $table->text('mo_ta')->nullable()->after('trang_thai');
    });
}
```

#### **3. Fix PhongHocController destroy()**

-   Thêm check `lichHocs()->count()`
-   Thêm check `lichThis()->count()`

#### **4. Tạo MonHocController**

```bash
php artisan make:controller Admin/MonHocController --resource
```

---

### **Priority 2 (Medium - Làm trong tuần):**

#### **5. Fix NganhController validation**

-   Thêm unique constraint theo `(ten_nganh, khoa_id)`
-   Update cả `store()` và `update()`

#### **6. Fix ChuyenNganhController validation**

-   Thêm unique constraint theo `(ten_chuyen_nganh, nganh_id)`
-   Update cả `store()` và `update()`

---

### **Priority 3 (Low - Làm khi có thời gian):**

#### **7. Implement Soft Delete cho Khoa**

```php
// Model
use Illuminate\Database\Eloquent\SoftDeletes;
use SoftDeletes;

// Migration
$table->softDeletes();
```

---

## 🎯 ƯỚC TÍNH THỜI GIAN

| Task                       | Time         | Difficulty |
| -------------------------- | ------------ | ---------- |
| Fix PhongHoc Model         | 5 phút       | Easy       |
| Tạo Migration PhongHoc     | 10 phút      | Easy       |
| Chạy Migration             | 2 phút       | Easy       |
| Fix PhongHoc destroy()     | 15 phút      | Easy       |
| Fix Nganh validation       | 10 phút      | Medium     |
| Fix ChuyenNganh validation | 10 phút      | Medium     |
| Tạo MonHocController       | 2-3 giờ      | Hard       |
| Tạo Views MonHoc           | 2-3 giờ      | Medium     |
| Implement Soft Delete      | 1 giờ        | Medium     |
| **TỔNG**                   | **~6-8 giờ** | -          |

---

## 📝 GHI CHÚ

### **Tại sao PhongHoc có nhiều field hơn ERD?**

-   ERD chỉ thiết kế cơ bản (3 fields)
-   Controller đã implement đầy đủ (7 fields)
-   **Cần cập nhật ERD hoặc giảm fields trong Controller**

### **Khuyến nghị:**

1. ✅ **Giữ 7 fields** (đầy đủ hơn, thực tế hơn)
2. ✅ **Cập nhật ERD** để match với implementation
3. ✅ **Tạo migration** ngay để fix database schema

---

**© 2025 S-MIS Code Review**

# 🚀 QUICK START - Admin Dashboard

## ✅ Đã Fix Lỗi

**Lỗi:** `InvalidArgumentException: Cannot end a section without first starting one`

**Nguyên nhân:** Có 2 lần `@endsection` trong file blade - cấu trúc sai

**Đã sửa:** Xóa `@endsection` và HTML code dư thừa ở cuối file

---

## 📖 Cách sử dụng

### 1. Truy cập Dashboard

```
URL: http://127.0.0.1:8000/admin/dashboard
```

### 2. Đảm bảo đã đăng nhập với tài khoản Admin

-   Email phải có trong bảng `admin`
-   Middleware `CheckAdmin` sẽ kiểm tra

### 3. Dashboard sẽ hiển thị:

#### ✨ 4 Stats Cards

-   📊 Tổng Users (với số users mới trong 7 ngày)
-   🎓 Sinh viên (với số SV mới trong 30 ngày)
-   👨‍🏫 Giảng viên
-   🏢 Khoa (với số ngành)

#### 📊 5 Biểu đồ Interactive

1. **Users theo Vai trò** - Donut Chart
2. **Sinh viên theo Trạng thái** - Bar Chart
3. **Top 5 Ngành** - Horizontal Bar
4. **Giảng viên theo Trình độ** - Pie Chart
5. **Tăng trưởng Users** - Area Chart

#### 📋 Recent Activity

-   Bảng 10 users mới nhất
-   Thời gian hiển thị dạng "5 minutes ago"
-   Click vào nút "Xem" để xem chi tiết

#### ⚡ Quick Actions

-   8 nút shortcut đến các trang quản lý quan trọng

---

## 🔧 Troubleshooting

### Nếu không hiển thị dữ liệu:

**Check 1: Database có data không?**

```bash
php artisan tinker
```

```php
\App\Models\User::count()
\App\Models\NhanSu\SinhVien::count()
\App\Models\NhanSu\GiangVien::count()
```

**Check 2: Relationships hoạt động không?**

```php
$user = \App\Models\User::first();
$user->admin; // Nếu user là admin
$user->sinhVien; // Nếu user là sinh viên
```

**Check 3: Clear cache**

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Nếu Charts không hiển thị:

**Check 1: ApexCharts loaded?**

-   Mở DevTools Console (F12)
-   Xem có lỗi JavaScript không?
-   Check ApexCharts CDN có load không?

**Check 2: Data có đúng format?**

-   Mở DevTools Console
-   Check biến `optionsUsersByRole`, etc.
-   Đảm bảo data không null/undefined

**Check 3: DOM elements tồn tại?**

```javascript
document.querySelector("#chartUsersByRole"); // Phải return element
```

---

## 📁 File Structure

```
app/Http/Controllers/Admin/
  └── AdminDashboardController.php  ← Controller với all queries

resources/views/admin/
  └── dashboard.blade.php            ← Main dashboard view

public/assets/css/
  └── custom-dashboard.css           ← Custom styles

resources/views/layouts/
  └── layout-admin.blade.php         ← Layout (đã thêm CSS link)
```

---

## 🎨 Customization

### Thay đổi màu sắc Charts:

File: `resources/views/admin/dashboard.blade.php`

```javascript
// Tìm dòng:
colors: ['#dc3545', '#0d6efd', '#0dcaf0', '#198754'],

// Thay bằng màu mới:
colors: ['#your-color-1', '#your-color-2', ...],
```

### Thêm/Bớt Stats Cards:

File: `resources/views/admin/dashboard.blade.php` (dòng 17-100)

Copy một card và sửa:

-   Icon class
-   Background color class (purple, blue, green, red)
-   Tên metric
-   Giá trị từ `$stats`

### Thêm Charts mới:

1. Thêm data query vào Controller
2. Pass data qua compact()
3. Thêm HTML div cho chart
4. Thêm JavaScript config trong @push('scripts')

---

## 📊 Performance Tips

### Cache Dashboard Data (Recommended):

File: `app/Http/Controllers/Admin/AdminDashboardController.php`

```php
use Illuminate\Support\Facades\Cache;

$stats = Cache::remember('admin.dashboard.stats', 300, function () {
    return [
        'total_users' => User::count(),
        // ... other stats
    ];
});
```

**Benefits:**

-   Giảm load database
-   Response nhanh hơn
-   Cache expire sau 5 phút (300 seconds)

### Lazy Load Charts:

Nếu có nhiều charts, có thể lazy load khi scroll vào viewport

### Database Indexing:

```sql
CREATE INDEX idx_created_at ON users(created_at);
CREATE INDEX idx_created_at ON sinh_vien(created_at);
```

---

## ✅ Checklist Deploy

-   [ ] Test dashboard trên môi trường local
-   [ ] Đảm bảo tất cả charts hiển thị
-   [ ] Kiểm tra responsive (mobile, tablet)
-   [ ] Test với nhiều browsers
-   [ ] Clear cache trước khi deploy
-   [ ] Backup database
-   [ ] Deploy CSS file mới
-   [ ] Test trên production
-   [ ] Monitor performance

---

## 📞 Support

Nếu có vấn đề, check:

1. Laravel logs: `storage/logs/laravel.log`
2. Browser Console (F12)
3. Network tab (check API calls)
4. Database connection

---

**Status:** ✅ Ready to use!

**Last Updated:** October 20, 2025

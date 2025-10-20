<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\KhoaController;
use App\Http\Controllers\Admin\NganhController;
use App\Http\Controllers\Admin\ChuyenNganhController;
use App\Http\Controllers\Admin\DmTrinhDoController;
use App\Http\Controllers\Admin\TrangThaiHocTapController;
use App\Http\Controllers\Admin\KhoaHocController;
use App\Http\Controllers\Admin\HocKyController;
use App\Http\Controllers\Admin\PhongHocController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\NotificationManagementController;
use App\Http\Controllers\DaoTao\DaoTaoDashboardController;
use App\Http\Controllers\GiangVien\GiangVienDashboardController;
use App\Http\Controllers\SinhVien\SinhVienDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard mặc định - sẽ redirect đến dashboard phù hợp
Route::get('/dashboard', function () {
    $user = auth()->user();

    // Kiểm tra vai trò và redirect
    if (\Illuminate\Support\Facades\DB::table('admin')->where('email', $user->email)->exists()) {
        return redirect()->route('admin.dashboard');
    }
    if (\Illuminate\Support\Facades\DB::table('dao_tao')->where('email', $user->email)->exists()) {
        return redirect()->route('dao-tao.dashboard');
    }
    if (\Illuminate\Support\Facades\DB::table('giang_vien')->where('email', $user->email)->exists()) {
        return redirect()->route('giang-vien.dashboard');
    }
    if (\Illuminate\Support\Facades\DB::table('sinh_vien')->where('email', $user->email)->exists()) {
        return redirect()->route('sinh-vien.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});

// Admin Routes - CHỈ ADMIN MỚI TRUY CẬP ĐƯỢC
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Quản lý Người dùng
    Route::resource('users', UserManagementController::class);
    // Reset password cho user
    Route::post('users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.resetPassword');

    // Quản lý Quyền
    Route::resource('permissions', PermissionController::class);

    // Quản lý Vai trò
    Route::resource('roles', RoleController::class);

    // Quản lý Thông báo
    Route::resource('notifications', NotificationManagementController::class);
    Route::delete('notifications/destroy-multiple', [NotificationManagementController::class, 'destroyMultiple'])->name('notifications.destroyMultiple');
    Route::get('notifications/stats', [NotificationManagementController::class, 'getStats'])->name('notifications.stats');

    // Test Notifications (Development only)
    Route::get('test-notifications', [\App\Http\Controllers\Admin\TestNotificationController::class, 'index'])->name('test-notifications.index');
    Route::post('test-notifications/send', [\App\Http\Controllers\Admin\TestNotificationController::class, 'send'])->name('test-notifications.send');

    // Quản lý Danh mục
    Route::resource('khoa', KhoaController::class);
    Route::resource('nganh', NganhController::class);
    Route::resource('chuyen-nganh', ChuyenNganhController::class);
    Route::resource('trinh-do', DmTrinhDoController::class);
    Route::resource('trang-thai-hoc-tap', TrangThaiHocTapController::class);

    // Quản lý Thời gian
    Route::resource('khoa-hoc', KhoaHocController::class);
    Route::resource('hoc-ky', HocKyController::class);

    // Quản lý Phòng học
    Route::resource('phong-hoc', PhongHocController::class);
});

// Đào tạo Routes
Route::prefix('dao-tao')->name('dao-tao.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DaoTaoDashboardController::class, 'index'])->name('dashboard');

    // Quản lý Sinh viên
    Route::resource('sinh-vien', \App\Http\Controllers\DaoTao\SinhVienController::class);

    // Quản lý Giảng viên
    Route::resource('giang-vien', \App\Http\Controllers\DaoTao\GiangVienController::class);

    // Quản lý lịch học phần
    Route::resource('lop-hoc-phan', \App\Http\Controllers\LichHoc\LopHocPhanController::class);

    // Quản lý lịch học
    Route::resource('lich-hoc', \App\Http\Controllers\LichHoc\LichHocController::class);

    // Quản lý lịch thi
    Route::resource('lich-thi', \App\Http\Controllers\LichHoc\LichThiController::class);
});

// Giảng viên Routes
Route::prefix('giang-vien')->name('giang-vien.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [GiangVienDashboardController::class, 'index'])->name('dashboard');
    // Thêm routes khác cho Giảng viên ở đây...
});

// Sinh viên Routes
Route::prefix('sinh-vien')->name('sinh-vien.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SinhVienDashboardController::class, 'index'])->name('dashboard');
    // Thêm routes khác cho Sinh viên ở đây...
});

require __DIR__ . '/auth.php';

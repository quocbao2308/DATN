<?php

/**
 * TEST NOTIFICATION HELPER
 * 
 * File này để test thử NotificationHelper
 * Chạy: php artisan tinker
 * Sau đó copy/paste các đoạn code bên dưới
 */

use App\Helpers\NotificationHelper;
use App\Models\User;

// ============================================
// TEST 1: Gửi thông báo đơn giản
// ============================================

$userId = 1; // Thay bằng ID user thật trong DB

NotificationHelper::send(
    nguoiNhanId: $userId,
    tieuDe: '🧪 Test thông báo',
    noiDung: 'Đây là thông báo test từ NotificationHelper',
    loai: 'thong_tin'
);

// Kiểm tra: Vào /notifications để xem thông báo


// ============================================
// TEST 2: Thông báo sinh viên được thêm vào lớp
// ============================================

NotificationHelper::notifyStudentAddedToClass(
    sinhVienId: $userId,
    tenLop: 'Lớp CNTT K17',
    tenMonHoc: 'Lập trình Web nâng cao',
    lienKet: '/lop-hoc/1'
);


// ============================================
// TEST 3: Thông báo điểm mới
// ============================================

NotificationHelper::notifyNewGrade(
    sinhVienId: $userId,
    tenMonHoc: 'Lập trình Web nâng cao',
    lienKet: '/diem'
);


// ============================================
// TEST 4: Cảnh báo điểm danh
// ============================================

NotificationHelper::notifyAttendanceWarning(
    sinhVienId: $userId,
    tenMonHoc: 'Lập trình Web nâng cao',
    soLanVang: 4,
    gioiHan: 5
);


// ============================================
// TEST 5: Vi phạm điểm danh
// ============================================

NotificationHelper::notifyAttendanceViolation(
    sinhVienId: $userId,
    tenMonHoc: 'Lập trình Web nâng cao',
    soLanVang: 6,
    gioiHan: 5
);


// ============================================
// TEST 6: Gửi cho nhiều người
// ============================================

$userIds = User::limit(3)->pluck('id')->toArray();

NotificationHelper::sendToMultiple(
    nguoiNhanIds: $userIds,
    tieuDe: '📢 Thông báo chung',
    noiDung: 'Đây là thông báo gửi cho nhiều người',
    loai: 'thong_tin'
);


// ============================================
// TEST 7: Gửi cho toàn bộ lớp (nếu có dữ liệu)
// ============================================

// Giả sử lớp có ID = 1 và có sinh viên trong bảng lop_hoc_sinh_vien
NotificationHelper::sendToClass(
    lopHocId: 1,
    tieuDe: '📚 Thông báo lớp học',
    noiDung: 'Lịch học tuần sau sẽ thay đổi. Vui lòng kiểm tra TKB.',
    loai: 'canh_bao'
);


// ============================================
// Kiểm tra kết quả
// ============================================

// Xem tất cả thông báo của user
$notifications = \App\Models\HeThong\ThongBao::where('nguoi_nhan_id', $userId)->get();
echo "Tổng số thông báo: " . $notifications->count();

// Xem thông báo mới nhất
$latest = \App\Models\HeThong\ThongBao::latest()->first();
echo "\nThông báo mới nhất:\n";
echo "- Tiêu đề: " . $latest->tieu_de . "\n";
echo "- Nội dung: " . $latest->noi_dung . "\n";
echo "- Loại: " . $latest->loai . "\n";

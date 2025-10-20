<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\User;
use Illuminate\Http\Request;

class TestNotificationController extends Controller
{
    /**
     * Hiển thị trang test thông báo
     */
    public function index()
    {
        return view('admin.test-notifications');
    }

    /**
     * Gửi thông báo test
     */
    public function send(Request $request)
    {
        $type = $request->input('type');
        $userId = $request->input('user_id', 1);
        $count = $request->input('count', 3);

        $message = '';

        switch ($type) {
            case 'student_added':
                NotificationHelper::notifyStudentAddedToClass(
                    sinhVienId: $userId,
                    tenLop: 'Lớp CNTT K17 (Test)',
                    tenMonHoc: 'Lập trình Web nâng cao',
                    lienKet: '/lop-hoc/1'
                );
                $message = '✅ Đã gửi thông báo "Thêm vào lớp học" cho user #' . $userId;
                break;

            case 'new_grade':
                NotificationHelper::notifyNewGrade(
                    sinhVienId: $userId,
                    tenMonHoc: 'Lập trình Web nâng cao',
                    lienKet: '/diem'
                );
                $message = '✅ Đã gửi thông báo "Có điểm mới" cho user #' . $userId;
                break;

            case 'attendance_warning':
                NotificationHelper::notifyAttendanceWarning(
                    sinhVienId: $userId,
                    tenMonHoc: 'Lập trình Web nâng cao',
                    soLanVang: 4,
                    gioiHan: 5
                );
                $message = '⚠️ Đã gửi thông báo "Cảnh báo điểm danh" cho user #' . $userId;
                break;

            case 'attendance_violation':
                NotificationHelper::notifyAttendanceViolation(
                    sinhVienId: $userId,
                    tenMonHoc: 'Lập trình Web nâng cao',
                    soLanVang: 6,
                    gioiHan: 5
                );
                $message = '🚫 Đã gửi thông báo "Vi phạm điểm danh" cho user #' . $userId;
                break;

            case 'teacher_assigned':
                NotificationHelper::notifyTeacherAssigned(
                    giangVienId: $userId,
                    tenLop: 'Lớp CNTT K17 (Test)',
                    tenMonHoc: 'Lập trình Web nâng cao',
                    lienKet: '/lop-hoc/1'
                );
                $message = '✅ Đã gửi thông báo "Phân công lớp" cho giảng viên #' . $userId;
                break;

            case 'class_nearly_full':
                NotificationHelper::notifyClassNearlyFull(
                    daoTaoId: $userId,
                    tenLop: 'Lớp CNTT K17 (Test)',
                    soSinhVien: 45,
                    sucChua: 50
                );
                $message = '⚠️ Đã gửi thông báo "Lớp gần đầy" cho đào tạo #' . $userId;
                break;

            case 'student_violation':
                NotificationHelper::notifyStudentViolation(
                    daoTaoId: $userId,
                    tenSinhVien: 'Nguyễn Văn A (Test)',
                    maSinhVien: 'PH12345',
                    tenMonHoc: 'Lập trình Web nâng cao'
                );
                $message = '🚫 Đã gửi thông báo "SV vi phạm" cho đào tạo #' . $userId;
                break;

            case 'new_user':
                NotificationHelper::notifyNewUser(
                    adminId: $userId,
                    tenUser: 'Nguyễn Văn B (Test)',
                    vaiTro: 'Sinh viên'
                );
                $message = '✅ Đã gửi thông báo "Tài khoản mới" cho admin #' . $userId;
                break;

            case 'send_to_multiple':
                $userIds = User::limit($count)->pluck('id')->toArray();
                $sent = NotificationHelper::sendToMultiple(
                    nguoiNhanIds: $userIds,
                    tieuDe: '📢 Thông báo test hàng loạt',
                    noiDung: 'Đây là thông báo test gửi cho nhiều người dùng cùng lúc.',
                    loai: 'thong_tin'
                );
                $message = "✅ Đã gửi thông báo cho {$sent} người dùng";
                break;

            default:
                $message = '❌ Loại thông báo không hợp lệ';
        }

        return redirect()->route('admin.test-notifications.index')
            ->with('success', $message);
    }
}

<?php

namespace App\Helpers;

use App\Models\HeThong\ThongBao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationHelper
{
    /**
     * Gửi thông báo với batch ID (dùng cho gửi nhiều)
     * 
     * @param int $nguoiNhanId ID người nhận
     * @param string $tieuDe Tiêu đề thông báo
     * @param string $noiDung Nội dung thông báo
     * @param string $loai Loại: thong_tin, canh_bao, quan_trong
     * @param string|null $lienKet Link chuyển hướng (optional)
     * @param string|null $batchId Batch ID để nhóm thông báo
     * @param int|null $nguoiTaoId ID người tạo (mặc định: user hiện tại)
     * @return ThongBao|null
     */
    private static function sendWithBatch(
        int $nguoiNhanId,
        string $tieuDe,
        string $noiDung,
        string $loai = 'thong_tin',
        ?string $lienKet = null,
        ?string $batchId = null,
        ?int $nguoiTaoId = null
    ): ?ThongBao {
        try {
            // Kiểm tra người nhận có tồn tại không
            if (!User::find($nguoiNhanId)) {
                Log::warning("NotificationHelper: Người nhận không tồn tại (ID: {$nguoiNhanId})");
                return null;
            }

            // Tạo thông báo
            $notification = ThongBao::create([
                'nguoi_nhan_id' => $nguoiNhanId,
                'nguoi_tao_id' => $nguoiTaoId ?? Auth::id() ?? 1,
                'tieu_de' => $tieuDe,
                'noi_dung' => $noiDung,
                'loai' => $loai,
                'vai_tro_nhan' => 'specific',
                'lien_ket' => $lienKet,
                'da_doc' => false,
                'batch_id' => $batchId,
            ]);

            Log::info("NotificationHelper: Đã gửi thông báo #{$notification->id} cho user #{$nguoiNhanId}" . ($batchId ? " (Batch: {$batchId})" : ""));
            return $notification;
        } catch (\Exception $e) {
            Log::error("NotificationHelper: Lỗi khi gửi thông báo - " . $e->getMessage());
            return null;
        }
    }

    /**
     * Gửi thông báo cho một người dùng
     * 
     * @param int $nguoiNhanId ID người nhận
     * @param string $tieuDe Tiêu đề thông báo
     * @param string $noiDung Nội dung thông báo
     * @param string $loai Loại: thong_tin, canh_bao, quan_trong
     * @param string|null $lienKet Link chuyển hướng (optional)
     * @param int|null $nguoiTaoId ID người tạo (mặc định: user hiện tại)
     * @return ThongBao|null
     */
    public static function send(
        int $nguoiNhanId,
        string $tieuDe,
        string $noiDung,
        string $loai = 'thong_tin',
        ?string $lienKet = null,
        ?int $nguoiTaoId = null
    ): ?ThongBao {
        return self::sendWithBatch($nguoiNhanId, $tieuDe, $noiDung, $loai, $lienKet, null, $nguoiTaoId);
    }

    /**
     * Gửi thông báo cho nhiều người dùng
     * 
     * @param array $nguoiNhanIds Mảng ID người nhận
     * @param string $tieuDe
     * @param string $noiDung
     * @param string $loai
     * @param string|null $lienKet
     * @return int Số lượng thông báo đã gửi thành công
     */
    public static function sendToMultiple(
        array $nguoiNhanIds,
        string $tieuDe,
        string $noiDung,
        string $loai = 'thong_tin',
        ?string $lienKet = null
    ): int {
        // Tạo batch ID để nhóm các thông báo
        $batchId = 'batch_' . time() . '_' . uniqid();

        $count = 0;
        foreach ($nguoiNhanIds as $id) {
            if (self::sendWithBatch($id, $tieuDe, $noiDung, $loai, $lienKet, $batchId)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Gửi thông báo cho tất cả sinh viên trong một lớp
     * 
     * @param int $lopHocId ID lớp học
     * @param string $tieuDe
     * @param string $noiDung
     * @param string $loai
     * @param string|null $lienKet
     * @return int Số lượng thông báo đã gửi
     */
    public static function sendToClass(
        int $lopHocId,
        string $tieuDe,
        string $noiDung,
        string $loai = 'thong_tin',
        ?string $lienKet = null
    ): int {
        try {
            // Lấy danh sách sinh viên trong lớp từ bảng lop_hoc_sinh_vien
            $sinhVienIds = DB::table('lop_hoc_sinh_vien')
                ->where('lop_hoc_id', $lopHocId)
                ->pluck('sinh_vien_id')
                ->toArray();

            if (empty($sinhVienIds)) {
                Log::warning("NotificationHelper: Lớp #{$lopHocId} không có sinh viên");
                return 0;
            }

            return self::sendToMultiple($sinhVienIds, $tieuDe, $noiDung, $loai, $lienKet);
        } catch (\Exception $e) {
            Log::error("NotificationHelper: Lỗi khi gửi thông báo cho lớp - " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Thông báo khi sinh viên được thêm vào lớp
     */
    public static function notifyStudentAddedToClass(int $sinhVienId, string $tenLop, string $tenMonHoc, ?string $lienKet = null): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $sinhVienId,
            tieuDe: "Bạn đã được thêm vào lớp học",
            noiDung: "Bạn đã được đăng ký vào lớp {$tenLop} - Môn: {$tenMonHoc}. Vui lòng kiểm tra thời khóa biểu của bạn.",
            loai: 'thong_tin',
            lienKet: $lienKet
        );
    }

    /**
     * Thông báo khi có điểm mới
     */
    public static function notifyNewGrade(int $sinhVienId, string $tenMonHoc, ?string $lienKet = null): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $sinhVienId,
            tieuDe: "Điểm của bạn đã được cập nhật",
            noiDung: "Điểm của bạn cho môn {$tenMonHoc} đã được giảng viên cập nhật. Hãy kiểm tra bảng điểm của bạn.",
            loai: 'thong_tin',
            lienKet: $lienKet
        );
    }

    /**
     * Thông báo cảnh báo điểm danh
     */
    public static function notifyAttendanceWarning(int $sinhVienId, string $tenMonHoc, int $soLanVang, int $gioiHan): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $sinhVienId,
            tieuDe: "⚠️ Cảnh báo điểm danh",
            noiDung: "Bạn đã vắng {$soLanVang} buổi học môn {$tenMonHoc}. Giới hạn cho phép là {$gioiHan} buổi. Vui lòng chú ý điểm danh!",
            loai: 'canh_bao',
            lienKet: null
        );
    }

    /**
     * Thông báo vi phạm điểm danh (vượt quá giới hạn)
     */
    public static function notifyAttendanceViolation(int $sinhVienId, string $tenMonHoc, int $soLanVang, int $gioiHan): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $sinhVienId,
            tieuDe: "🚫 Vi phạm điểm danh",
            noiDung: "Bạn đã vi phạm điểm danh môn {$tenMonHoc} với {$soLanVang}/{$gioiHan} buổi vắng. Vui lòng liên hệ phòng Đào tạo!",
            loai: 'quan_trong',
            lienKet: null
        );
    }

    /**
     * Thông báo cho giảng viên khi được phân công lớp
     */
    public static function notifyTeacherAssigned(int $giangVienId, string $tenLop, string $tenMonHoc, ?string $lienKet = null): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $giangVienId,
            tieuDe: "Bạn được phân công giảng dạy",
            noiDung: "Bạn đã được phân công giảng dạy lớp {$tenLop} - Môn: {$tenMonHoc}. Vui lòng kiểm tra lịch giảng dạy.",
            loai: 'thong_tin',
            lienKet: $lienKet
        );
    }

    /**
     * Thông báo cho đào tạo khi lớp gần đầy
     */
    public static function notifyClassNearlyFull(int $daoTaoId, string $tenLop, int $soSinhVien, int $sucChua): ?ThongBao
    {
        $phanTram = round(($soSinhVien / $sucChua) * 100);
        return self::send(
            nguoiNhanId: $daoTaoId,
            tieuDe: "⚠️ Lớp học sắp đầy",
            noiDung: "Lớp {$tenLop} hiện có {$soSinhVien}/{$sucChua} sinh viên ({$phanTram}%). Vui lòng cân nhắc mở thêm lớp.",
            loai: 'canh_bao',
            lienKet: null
        );
    }

    /**
     * Thông báo cho đào tạo khi có sinh viên vi phạm điểm danh
     */
    public static function notifyStudentViolation(int $daoTaoId, string $tenSinhVien, string $maSinhVien, string $tenMonHoc): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $daoTaoId,
            tieuDe: "🚫 Sinh viên vi phạm điểm danh",
            noiDung: "Sinh viên {$tenSinhVien} ({$maSinhVien}) đã vi phạm điểm danh môn {$tenMonHoc}. Vui lòng xem xét xử lý.",
            loai: 'quan_trong',
            lienKet: null
        );
    }

    /**
     * Thông báo cho admin khi có tài khoản mới
     */
    public static function notifyNewUser(int $adminId, string $tenUser, string $vaiTro): ?ThongBao
    {
        return self::send(
            nguoiNhanId: $adminId,
            tieuDe: "Tài khoản mới được tạo",
            noiDung: "Tài khoản mới: {$tenUser} - Vai trò: {$vaiTro}",
            loai: 'thong_tin',
            lienKet: null
        );
    }
}

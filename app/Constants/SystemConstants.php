<?php

namespace App\Constants;

class SystemConstants
{
    /**
     * Các hình thức giảng dạy
     */
    const TEACHING_MODES = [
        'offline' => 'Offline (Tại lớp)',
        'online' => 'Online (Trực tuyến)',
        'hybrid' => 'Hybrid (Kết hợp)',
    ];

    /**
     * Trạng thái học phí
     */
    const HOC_PHI_STATUS = [
        'chua_nop' => 'Chưa nộp',
        'da_nop' => 'Đã nộp',
        'no' => 'Nợ',
    ];

    /**
     * Trạng thái điểm danh
     */
    const DIEM_DANH_STATUS = [
        'co_mat' => 'Có mặt',
        'vang' => 'Vắng',
        'di_tre' => 'Đi trễ',
        'nghi_phep' => 'Nghỉ phép',
    ];

    /**
     * Trạng thái lớp học phần
     */
    const LOP_HOC_PHAN_STATUS = [
        'mo_dang_ky' => 'Mở đăng ký',
        'dang_hoc' => 'Đang học',
        'ket_thuc' => 'Kết thúc',
        'huy' => 'Hủy',
    ];

    /**
     * Loại môn học
     */
    const LOAI_MON_HOC = [
        'bat_buoc' => 'Bắt buộc',
        'chuyen_nganh' => 'Chuyên ngành',
        'tu_chon' => 'Tự chọn',
    ];
}

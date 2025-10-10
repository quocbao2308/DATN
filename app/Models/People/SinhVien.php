<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $table = 'sinh_vien';

    protected $fillable = [
        'ma_sinh_vien',
        'ho_ten',
        'email',
        'ngay_sinh',
        'gioi_tinh',
        'so_dien_thoai',
        'can_cuoc_cong_dan',
        'khoa_hoc_id',
        'nganh_id',
        'chuyen_nganh_id',
        'trang_thai_hoc_tap_id',
    ];

    /**
     * Ngành
     */
    public function nganh()
    {
        return $this->belongsTo(\App\Models\Academic\Nganh::class, 'nganh_id');
    }

    /**
     * Chuyên ngành
     */
    public function chuyenNganh()
    {
        return $this->belongsTo(\App\Models\Academic\ChuyenNganh::class, 'chuyen_nganh_id');
    }

    /**
     * Khóa học
     */
    public function khoaHoc()
    {
        return $this->belongsTo(\App\Models\System\KhoaHoc::class, 'khoa_hoc_id');
    }

    /**
     * Trạng thái học tập
     */
    public function trangThaiHocTap()
    {
        return $this->belongsTo(\App\Models\System\TrangThaiHocTap::class, 'trang_thai_hoc_tap_id');
    }
}

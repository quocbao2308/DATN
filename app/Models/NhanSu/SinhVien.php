<?php

namespace App\Models\NhanSu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SinhVien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sinh_vien';

    protected $fillable = [
        'user_id',
        'ma_sinh_vien',
        'ho_ten',
        'email',
        'ngay_sinh',
        'gioi_tinh',
        'so_dien_thoai',
        // Địa chỉ
        'so_nha_duong',
        'phuong_xa',
        'quan_huyen',
        'tinh_thanh',
        // CCCD
        'can_cuoc_cong_dan',
        'ngay_cap_cccd',
        'noi_cap_cccd',
        // Khác
        'anh_dai_dien',
        'ky_hien_tai',
        // Foreign keys
        'khoa_hoc_id',
        'nganh_id',
        'chuyen_nganh_id',
        'trang_thai_hoc_tap_id',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'ngay_cap_cccd' => 'date',
        'ky_hien_tai' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * User account
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Ngành
     */
    public function nganh()
    {
        return $this->belongsTo(\App\Models\DaoTao\Nganh::class, 'nganh_id');
    }

    /**
     * Chuyên ngành
     */
    public function chuyenNganh()
    {
        return $this->belongsTo(\App\Models\DaoTao\ChuyenNganh::class, 'chuyen_nganh_id');
    }

    /**
     * Khóa học
     */
    public function khoaHoc()
    {
        return $this->belongsTo(\App\Models\HeThong\KhoaHoc::class, 'khoa_hoc_id');
    }

    /**
     * Trạng thái học tập
     */
    public function trangThaiHocTap()
    {
        return $this->belongsTo(\App\Models\HeThong\TrangThaiHocTap::class, 'trang_thai_hoc_tap_id');
    }

    /**
     * Accessor - Địa chỉ đầy đủ
     */
    public function getDiaChiDayDuAttribute()
    {
        $parts = array_filter([
            $this->so_nha_duong,
            $this->phuong_xa,
            $this->quan_huyen,
            $this->tinh_thanh,
        ]);

        return !empty($parts) ? implode(', ', $parts) : 'Chưa cập nhật';
    }

    /**
     * Accessor - URL ảnh đại diện
     */
    public function getAnhDaiDienUrlAttribute()
    {
        return $this->anh_dai_dien
            ? asset('storage/' . $this->anh_dai_dien)
            : asset('assets/images/avatar-default.png');
    }
}

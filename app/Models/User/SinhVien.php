<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\TaiKhoan;
use App\Models\Academic\{Nganh, ChuyenNganh};
use App\Models\System\{KhoaHoc, TrangThaiHocTap};

class SinhVien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sinh_vien';

    protected $fillable = [
        'ma_sinh_vien',
        'ho_ten',
        'email',
        'ngay_sinh',
        'gioi_tinh',
        'so_dien_thoai',
        'so_nha_duong',
        'phuong_xa',
        'quan_huyen',
        'tinh_thanh',
        'can_cuoc_cong_dan',
        'ngay_cap_cccd',
        'noi_cap_cccd',
        'anh_dai_dien',
        'khoa_hoc_id',
        'nganh_id',
        'chuyen_nganh_id',
        'ky_hien_tai',
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
     * Relationships
     */

    // SinhVien belongs to KhoaHoc
    public function khoaHoc()
    {
        return $this->belongsTo(KhoaHoc::class, 'khoa_hoc_id');
    }

    // SinhVien belongs to Nganh
    public function nganh()
    {
        return $this->belongsTo(Nganh::class, 'nganh_id');
    }

    // SinhVien belongs to ChuyenNganh
    public function chuyenNganh()
    {
        return $this->belongsTo(ChuyenNganh::class, 'chuyen_nganh_id');
    }

    // SinhVien belongs to TrangThaiHocTap
    public function trangThaiHocTap()
    {
        return $this->belongsTo(TrangThaiHocTap::class, 'trang_thai_hoc_tap_id');
    }

    // SinhVien has one TaiKhoan
    public function taiKhoan()
    {
        return $this->hasOne(TaiKhoan::class, 'sinh_vien_id');
    }

    /**
     * Accessors & Mutators
     */
    public function getAnhDaiDienUrlAttribute()
    {
        if ($this->anh_dai_dien) {
            return asset('storage/' . $this->anh_dai_dien);
        }
        return asset('assets/images/faces/default-avatar.png');
    }

    public function getDiaChiDayDuAttribute()
    {
        $parts = array_filter([
            $this->so_nha_duong,
            $this->phuong_xa,
            $this->quan_huyen,
            $this->tinh_thanh
        ]);

        return implode(', ', $parts);
    }

    public function getTenDayDuAttribute()
    {
        return $this->ho_ten;
    }
}

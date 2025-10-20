<?php

namespace App\Models\HocPhi;

use App\Models\NhanSu\SinhVien;
use App\Models\HeThong\HocKy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocPhi extends Model
{
    use HasFactory;

    protected $table = 'hoc_phi';

    protected $fillable = [
        'sinh_vien_id',
        'hoc_ky_id',
        'so_tien',
        'ngay_nop',
        'trang_thai',
        'ghi_chu',
    ];

    protected $casts = [
        'so_tien' => 'float',
        'ngay_nop' => 'datetime',
    ];

    /**
     * Relationship: Học phí thuộc về một sinh viên
     */
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class, 'sinh_vien_id');
    }

    /**
     * Relationship: Học phí thuộc về một học kỳ
     */
    public function hocKy()
    {
        return $this->belongsTo(HocKy::class, 'hoc_ky_id');
    }

    /**
     * Scope: Lọc theo trạng thái
     */
    public function scopeTrangThai($query, $trangThai)
    {
        if ($trangThai) {
            return $query->where('trang_thai', $trangThai);
        }
        return $query;
    }

    /**
     * Scope: Lọc theo học kỳ
     */
    public function scopeHocKy($query, $hocKyId)
    {
        if ($hocKyId) {
            return $query->where('hoc_ky_id', $hocKyId);
        }
        return $query;
    }

    /**
     * Scope: Lọc theo sinh viên
     */
    public function scopeSinhVien($query, $sinhVienId)
    {
        if ($sinhVienId) {
            return $query->where('sinh_vien_id', $sinhVienId);
        }
        return $query;
    }
}

<?php

namespace App\Models\LichHoc;

use App\Models\NhanSu\SinhVien;
use App\Models\LichHoc\LichHoc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiemDanh extends Model
{
    use HasFactory;

    protected $table = 'diem_danh';

    protected $fillable = [
        'sinh_vien_id',
        'lich_hoc_id',
        'trang_thai',
        'ngay_diem_danh',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_diem_danh' => 'datetime',
    ];

    /**
     * Relationship: Điểm danh thuộc về một sinh viên
     */
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class, 'sinh_vien_id');
    }

    /**
     * Relationship: Điểm danh thuộc về một buổi học
     */
    public function lichHoc()
    {
        return $this->belongsTo(LichHoc::class, 'lich_hoc_id');
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
     * Scope: Lọc theo buổi học
     */
    public function scopeLichHoc($query, $lichHocId)
    {
        if ($lichHocId) {
            return $query->where('lich_hoc_id', $lichHocId);
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

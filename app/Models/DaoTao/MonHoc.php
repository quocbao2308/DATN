<?php

namespace App\Models\DaoTao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonHoc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mon_hoc';

    protected $fillable = [
        'ma_mon',
        'ten_mon',
        'so_tin_chi',
        'mo_ta',
        'loai_mon',
        'hinh_thuc_day',
        'thoi_luong',
        'so_buoi',
    ];

    protected $casts = [
        'so_tin_chi' => 'integer',
        'thoi_luong' => 'integer',
        'so_buoi' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Môn học tiên quyết (self-referencing many-to-many)
    public function monTienQuyets()
    {
        return $this->belongsToMany(
            MonHoc::class,
            'mon_hoc_tien_quyet',
            'mon_hoc_id',
            'mon_tien_quyet_id'
        );
    }

    // Các môn học cần môn này làm tiên quyết
    public function monHocCanTienQuyet()
    {
        return $this->belongsToMany(
            MonHoc::class,
            'mon_hoc_tien_quyet',
            'mon_tien_quyet_id',
            'mon_hoc_id'
        );
    }

    // One MonHoc has many LopHocPhan
    public function lopHocPhans()
    {
        return $this->hasMany(LopHocPhan::class, 'mon_hoc_id');
    }

    // One MonHoc có trong nhiều ChuongTrinhKhung
    public function chuongTrinhKhungs()
    {
        return $this->hasMany(ChuongTrinhKhung::class, 'mon_hoc_id');
    }
}

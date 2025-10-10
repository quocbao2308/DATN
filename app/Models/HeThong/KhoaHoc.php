<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoaHoc extends Model
{
    use HasFactory;

    protected $table = 'khoa_hoc';

    protected $fillable = [
        'ten_khoa_hoc',
        'nam_bat_dau',
        'nam_ket_thuc',
    ];

    protected $casts = [
        'nam_bat_dau' => 'integer',
        'nam_ket_thuc' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function sinhViens()
    {
        return $this->hasMany(\App\Models\NhanSu\SinhVien::class, 'khoa_hoc_id');
    }
}

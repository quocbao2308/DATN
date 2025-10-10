<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocKy extends Model
{
    use HasFactory;

    protected $table = 'hoc_ky';

    protected $fillable = [
        'ten_hoc_ky',
        'nam_bat_dau',
        'nam_ket_thuc',
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];

    protected $casts = [
        'nam_bat_dau' => 'integer',
        'nam_ket_thuc' => 'integer',
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function lopHocPhans()
    {
        return $this->hasMany(\App\Models\DaoTao\LopHocPhan::class, 'hoc_ky_id');
    }

    public function bangDiems()
    {
        return $this->hasMany(\App\Models\Grade\BangDiem::class, 'hoc_ky_id');
    }

    public function hocPhis()
    {
        return $this->hasMany(\App\Models\Finance\HocPhi::class, 'hoc_ky_id');
    }
}

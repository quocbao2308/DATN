<?php

namespace App\Models\NhanSu;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $table = 'giang_vien';

    protected $fillable = [
        'ma_giang_vien',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'khoa_id',
        'trinh_do_id',
        'chuyen_mon',
    ];

    /**
     * Khoa
     */
    public function khoa()
    {
        return $this->belongsTo(\App\Models\DaoTao\Khoa::class, 'khoa_id');
    }

    /**
     * Trình độ
     */
    public function trinhDo()
    {
        return $this->belongsTo(\App\Models\HeThong\DmTrinhDo::class, 'trinh_do_id');
    }
}

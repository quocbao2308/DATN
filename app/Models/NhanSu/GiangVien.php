<?php

namespace App\Models\NhanSu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiangVien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'giang_vien';

    protected $fillable = [
        'user_id',
        'ma_giang_vien',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'khoa_id',
        'trinh_do_id',
        'chuyen_mon',
        'ngay_vao_truong',
        'anh_dai_dien',
    ];

    protected $casts = [
        'ngay_vao_truong' => 'date',
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

<?php

namespace App\Models\DaoTao;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    protected $table = 'khoa';

    protected $fillable = [
        'ten_khoa',
    ];

    /**
     * Các ngành thuộc khoa
     */
    public function nganhs()
    {
        return $this->hasMany(Nganh::class, 'khoa_id');
    }

    /**
     * Các giảng viên thuộc khoa
     */
    public function giangViens()
    {
        return $this->hasMany(\App\Models\NhanSu\GiangVien::class, 'khoa_id');
    }
}

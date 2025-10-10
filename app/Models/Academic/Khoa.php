<?php

namespace App\Models\Academic;

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
        return $this->hasMany(\App\Models\People\GiangVien::class, 'khoa_id');
    }
}

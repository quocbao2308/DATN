<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academic\Nganh;
use App\Models\User\GiangVien;

class Khoa extends Model
{
    use HasFactory;

    protected $table = 'khoa';

    protected $fillable = [
        'ten_khoa',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // One Khoa has many Nganh
    public function nganhs()
    {
        return $this->hasMany(Nganh::class, 'khoa_id');
    }

    // One Khoa has many GiangVien
    public function giangViens()
    {
        return $this->hasMany(GiangVien::class, 'khoa_id');
    }
}

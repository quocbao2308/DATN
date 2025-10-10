<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrangThaiHocTap extends Model
{
    use HasFactory;

    protected $table = 'trang_thai_hoc_tap';

    protected $fillable = [
        'ten_trang_thai',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function sinhViens()
    {
        return $this->hasMany(\App\Models\User\SinhVien::class, 'trang_thai_hoc_tap_id');
    }
}

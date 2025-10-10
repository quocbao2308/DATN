<?php

namespace App\Models\DaoTao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HeThong\Khoa;
use App\Models\NhanSu\SinhVien;

class Nganh extends Model
{
    use HasFactory;

    protected $table = 'nganh';

    protected $fillable = [
        'ten_nganh',
        'khoa_id',
    ];

    protected $casts = [
        'khoa_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Nganh belongs to Khoa
    public function khoa()
    {
        return $this->belongsTo(Khoa::class, 'khoa_id');
    }

    // One Nganh has many ChuyenNganh
    public function chuyenNganhs()
    {
        return $this->hasMany(ChuyenNganh::class, 'nganh_id');
    }

    // One Nganh has many SinhVien
    public function sinhViens()
    {
        return $this->hasMany(SinhVien::class, 'nganh_id');
    }
}

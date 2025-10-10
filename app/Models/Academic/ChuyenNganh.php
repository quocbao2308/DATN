<?php

namespace App\Models\Academic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\SinhVien;

class ChuyenNganh extends Model
{
    use HasFactory;

    protected $table = 'chuyen_nganh';

    protected $fillable = [
        'ten_chuyen_nganh',
        'nganh_id',
    ];

    protected $casts = [
        'nganh_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // ChuyenNganh belongs to Nganh
    public function nganh()
    {
        return $this->belongsTo(Nganh::class, 'nganh_id');
    }

    // One ChuyenNganh has many SinhVien
    public function sinhViens()
    {
        return $this->hasMany(SinhVien::class, 'chuyen_nganh_id');
    }

    // One ChuyenNganh has many ChuongTrinhKhung
    public function chuongTrinhKhungs()
    {
        return $this->hasMany(ChuongTrinhKhung::class, 'chuyen_nganh_id');
    }
}

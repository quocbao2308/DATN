<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\TaiKhoan;
use App\Models\System\{Khoa, DmTrinhDo};

class GiangVien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'giang_vien';

    protected $fillable = [
        'ma_giang_vien',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'trinh_do_id',
        'chuyen_mon',
        'khoa_id',
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
     * Relationships
     */

    // GiangVien belongs to Khoa
    public function khoa()
    {
        return $this->belongsTo(Khoa::class, 'khoa_id');
    }

    // GiangVien belongs to DmTrinhDo
    public function trinhDo()
    {
        return $this->belongsTo(DmTrinhDo::class, 'trinh_do_id');
    }

    // GiangVien has one TaiKhoan
    public function taiKhoan()
    {
        return $this->hasOne(TaiKhoan::class, 'giang_vien_id');
    }

    /**
     * Accessors & Mutators
     */
    public function getAnhDaiDienUrlAttribute()
    {
        if ($this->anh_dai_dien) {
            return asset('storage/' . $this->anh_dai_dien);
        }
        return asset('assets/images/faces/default-avatar.png');
    }
}

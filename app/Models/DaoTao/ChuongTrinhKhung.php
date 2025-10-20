<?php

namespace App\Models\DaoTao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuongTrinhKhung extends Model
{
    use HasFactory;

    protected $table = 'chuong_trinh_khung';

    protected $fillable = [
        'chuyen_nganh_id',
        'mon_hoc_id',
        'hoc_ky_goi_y',
        'loai_mon_hoc',
    ];

    /**
     * Relationship: Chương trình khung thuộc về một chuyên ngành
     */
    public function chuyenNganh()
    {
        return $this->belongsTo(ChuyenNganh::class, 'chuyen_nganh_id');
    }

    /**
     * Relationship: Chương trình khung có một môn học
     */
    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }
}

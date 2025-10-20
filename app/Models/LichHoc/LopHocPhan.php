<?php

namespace App\Models\LichHoc;

use App\Models\DaoTao\MonHoc;
use App\Models\HeThong\HocKy;
use App\Models\LichHoc\LichHoc;
use App\Models\LichHoc\LichThi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopHocPhan extends Model
{
    use HasFactory;

    protected $table = 'lop_hoc_phan';

    protected $fillable = [
        'ma_lop_hp',
        'mon_hoc_id',
        'hoc_ky_id',
        'suc_chua',
        'hinh_thuc',
        'link_online',
        'ghi_chu',
        'trang_thai_lop'
    ];

    // Quan hệ
    public function monHoc() {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }

    public function hocKy() {
        return $this->belongsTo(HocKy::class, 'hoc_ky_id');
    }

    public function lichHoc() {
        return $this->hasMany(LichHoc::class, 'lop_hoc_phan_id');
    }

    public function lichThi() {
        return $this->hasMany(LichThi::class, 'lop_hoc_phan_id');
    }
}

?>
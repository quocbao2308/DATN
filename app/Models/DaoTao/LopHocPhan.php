<?php

namespace App\Models\DaoTao;

use App\Models\HeThong\HocKy;
use App\Models\NhanSu\SinhVien;
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
        'trang_thai_lop',
    ];

    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }

    public function hocKy()
    {
        return $this->belongsTo(HocKy::class, 'hoc_ky_id');
    }

    public function sinhVien()
    {
        return $this->belongsToMany(SinhVien::class, 'sinh_vien_lop_hoc_phan', 'lop_hoc_phan_id', 'sinh_vien_id');
    }
}

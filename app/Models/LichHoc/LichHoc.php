<?php
namespace App\Models\LichHoc;

use App\Models\NhanSu\GiangVien;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichHoc extends Model
{
    use HasFactory;

    protected $table = 'lich_hoc';
    protected $fillable = [
        'lop_hoc_phan_id',
        'ngay',
        'gio_bat_dau',
        'gio_ket_thuc',
        'phong_hoc_id',
        'hinh_thuc_buoi_hoc',
        'link_online',
        'giang_vien_phu_trach',
        'ghi_chu'
    ];

    public function lopHocPhan() {
        return $this->belongsTo(lopHocPhan::class);
    }

    public function phongHoc() {
        return $this->belongsTo(PhongHoc::class);
    }

    public function giangVien() {
        return $this->belongsTo(GiangVien::class, 'giang_vien_phu_trach');
    }
}

?>
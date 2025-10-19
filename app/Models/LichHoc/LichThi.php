<?php
namespace App\Models\LichHoc;

use App\Models\LichHoc\LopHocPhan;
use App\Models\LichHoc\PhongHoc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichThi extends Model
{
    use HasFactory;

    protected $table = 'lich_thi';
    protected $fillable = [
        'lop_hoc_phan_id',
        'ngay_thi',
        'gio_bat_dau',
        'gio_ket_thuc',
        'phong_hoc_id',
        'hinh_thuc',
        'link_online',
        'file_pdf',
        'ngay_gui'
    ];

    public function lopHocPhan() {
        return $this->belongsTo(LopHocPhan::class);
    }

    public function phongHoc() {
        return $this->belongsTo(PhongHoc::class);
    }
}

?>
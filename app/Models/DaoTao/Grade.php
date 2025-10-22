<?php

namespace App\Models\DaoTao;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['sinh_vien_id','mon_hoc_id','diem_qua_trinh','diem_thi','diem_tong_ket'];

public function sinhVien()
{
    return $this->belongsTo(\App\Models\NhanSu\SinhVien::class, 'sinh_vien_id');
}

public function monHoc()
{
    return $this->belongsTo(\App\Models\DaoTao\MonHoc::class, 'mon_hoc_id');
}
}
// Ghí chsu quản lý đểm 
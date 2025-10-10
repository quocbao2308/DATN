<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Academic\Khoa;
use App\Models\Academic\Nganh;
use App\Models\People\SinhVien;
use App\Models\People\GiangVien;
use App\Models\System\KhoaHoc;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Thống kê cho Admin
        $stats = [
            'total_khoa' => Khoa::count(),
            'total_nganh' => Nganh::count(),
            'total_sinh_vien' => SinhVien::count(),
            'total_giang_vien' => GiangVien::count(),
            'total_khoa_hoc' => KhoaHoc::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

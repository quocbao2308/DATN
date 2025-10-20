<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaoTao\Khoa;
use App\Models\DaoTao\Nganh;
use App\Models\NhanSu\SinhVien;
use App\Models\NhanSu\GiangVien;
use App\Models\HeThong\KhoaHoc;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $stats = [
            'total_khoa' => Khoa::count(),
            'total_nganh' => Nganh::count(),
            'total_sinh_vien' => SinhVien::count(),
            'total_giang_vien' => GiangVien::count(),
            'total_khoa_hoc' => KhoaHoc::count(),
            'total_users' => User::count(),
        ];

        // Thống kê users theo vai trò
        $usersByRole = [
            'admin' => DB::table('admin')->count(),
            'dao_tao' => DB::table('dao_tao')->count(),
            'giang_vien' => DB::table('giang_vien')->count(),
            'sinh_vien' => DB::table('sinh_vien')->count(),
        ];

        // Thống kê sinh viên theo trạng thái
        $sinhVienByStatus = DB::table('sinh_vien')
            ->join('trang_thai_hoc_tap', 'sinh_vien.trang_thai_hoc_tap_id', '=', 'trang_thai_hoc_tap.id')
            ->select('trang_thai_hoc_tap.ten_trang_thai', DB::raw('count(*) as total'))
            ->groupBy('trang_thai_hoc_tap.ten_trang_thai', 'trang_thai_hoc_tap.id')
            ->get();

        // Thống kê sinh viên theo ngành (Top 5)
        $sinhVienByNganh = DB::table('sinh_vien')
            ->join('nganh', 'sinh_vien.nganh_id', '=', 'nganh.id')
            ->select('nganh.ten_nganh', DB::raw('count(*) as total'))
            ->groupBy('nganh.ten_nganh', 'nganh.id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Thống kê giảng viên theo khoa
        $giangVienByKhoa = DB::table('giang_vien')
            ->join('khoa', 'giang_vien.khoa_id', '=', 'khoa.id')
            ->select('khoa.ten_khoa', DB::raw('count(*) as total'))
            ->groupBy('khoa.ten_khoa', 'khoa.id')
            ->get();

        // Thống kê giảng viên theo trình độ
        $giangVienByTrinhDo = DB::table('giang_vien')
            ->join('dm_trinh_do', 'giang_vien.trinh_do_id', '=', 'dm_trinh_do.id')
            ->select('dm_trinh_do.ten_trinh_do', DB::raw('count(*) as total'))
            ->groupBy('dm_trinh_do.ten_trinh_do', 'dm_trinh_do.id')
            ->get();

        // Users mới trong 7 ngày
        $newUsersLast7Days = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Users mới trong 30 ngày
        $newUsersLast30Days = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Sinh viên mới trong 30 ngày
        $newSinhVienLast30Days = SinhVien::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Thống kê users theo tháng (6 tháng gần nhất)
        $usersByMonth = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Hoạt động gần đây (10 users mới nhất)
        $recentUsers = User::with(['admin', 'daoTao', 'giangVien', 'sinhVien'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Gán vai trò cho recent users
        foreach ($recentUsers as $user) {
            $user->role = $this->getUserRole($user->email);
        }

        return view('admin.dashboard', compact(
            'stats',
            'usersByRole',
            'sinhVienByStatus',
            'sinhVienByNganh',
            'giangVienByKhoa',
            'giangVienByTrinhDo',
            'newUsersLast7Days',
            'newUsersLast30Days',
            'newSinhVienLast30Days',
            'usersByMonth',
            'recentUsers'
        ));
    }

    /**
     * Xác định vai trò của user
     */
    private function getUserRole($email)
    {
        if (DB::table('admin')->where('email', $email)->exists()) {
            return 'Admin';
        }
        if (DB::table('dao_tao')->where('email', $email)->exists()) {
            return 'Đào tạo';
        }
        if (DB::table('giang_vien')->where('email', $email)->exists()) {
            return 'Giảng viên';
        }
        if (DB::table('sinh_vien')->where('email', $email)->exists()) {
            return 'Sinh viên';
        }
        return 'Chưa xác định';
    }
}

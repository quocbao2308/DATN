<?php

namespace App\Http\Controllers\LichHoc;

use App\Http\Controllers\Controller;
use App\Models\LichHoc\DiemDanh;
use App\Models\LichHoc\LichHoc;
use App\Models\DaoTao\LopHocPhan;
use App\Models\NhanSu\SinhVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiemDanhController extends Controller
{
    /**
     * Hiển thị danh sách buổi học để điểm danh
     */
    public function index(Request $request)
    {
        $query = LichHoc::with(['lopHocPhan', 'phongHoc', 'giangVien']);

        // Filter theo lớp học phần
        if ($request->filled('lop_hoc_phan_id')) {
            $query->where('lop_hoc_phan_id', $request->lop_hoc_phan_id);
        }

        // Filter theo ngày
        if ($request->filled('ngay')) {
            $query->whereDate('ngay', $request->ngay);
        }

        // Filter chỉ hiển thị buổi học chưa điểm danh
        if ($request->filled('chua_diem_danh') && $request->chua_diem_danh == '1') {
            $query->whereDoesntHave('diemDanh');
        }

        $danhSachLichHoc = $query->orderBy('ngay', 'desc')
            ->orderBy('gio_bat_dau', 'asc')
            ->paginate(20);

        // Lấy danh sách lớp học phần cho filter
        $danhSachLopHocPhan = LopHocPhan::orderBy('ma_lop_hp')->get();

        return view('diem-danh.index', compact('danhSachLichHoc', 'danhSachLopHocPhan'));
    }

    /**
     * Hiển thị form điểm danh cho một buổi học
     */
    public function create($lichHocId)
    {
        $lichHoc = LichHoc::with(['lopHocPhan', 'phongHoc', 'giangVien'])->findOrFail($lichHocId);

        // Lấy danh sách sinh viên trong lớp học phần
        $danhSachSinhVien = DB::table('sinh_vien_lop_hoc_phan')
            ->join('sinh_vien', 'sinh_vien_lop_hoc_phan.sinh_vien_id', '=', 'sinh_vien.id')
            ->where('sinh_vien_lop_hoc_phan.lop_hoc_phan_id', $lichHoc->lop_hoc_phan_id)
            ->select('sinh_vien.*')
            ->orderBy('sinh_vien.ma_sinh_vien')
            ->get();

        // Lấy điểm danh đã có (nếu có)
        $diemDanhDaCo = DiemDanh::where('lich_hoc_id', $lichHocId)
            ->pluck('trang_thai', 'sinh_vien_id')
            ->toArray();

        return view('diem-danh.create', compact('lichHoc', 'danhSachSinhVien', 'diemDanhDaCo'));
    }

    /**
     * Lưu điểm danh hàng loạt
     */
    public function store(Request $request, $lichHocId)
    {
        $validated = $request->validate([
            'diem_danh' => 'required|array',
            'diem_danh.*' => 'required|in:co_mat,vang,di_tre,nghi_phep',
            'ghi_chu' => 'nullable|array',
            'ghi_chu.*' => 'nullable|string',
        ]);

        $lichHoc = LichHoc::findOrFail($lichHocId);

        // Xóa điểm danh cũ nếu có
        DiemDanh::where('lich_hoc_id', $lichHocId)->delete();

        // Lưu điểm danh mới
        foreach ($validated['diem_danh'] as $sinhVienId => $trangThai) {
            DiemDanh::create([
                'sinh_vien_id' => $sinhVienId,
                'lich_hoc_id' => $lichHocId,
                'trang_thai' => $trangThai,
                'ngay_diem_danh' => now(),
                'ghi_chu' => $request->ghi_chu[$sinhVienId] ?? null,
            ]);
        }

        return redirect()->route('diem-danh.index')
            ->with('success', 'Đã điểm danh thành công cho buổi học ngày ' . $lichHoc->ngay);
    }

    /**
     * Hiển thị thống kê điểm danh
     */
    public function thongKe(Request $request)
    {
        $query = DiemDanh::with(['sinhVien', 'lichHoc.lopHocPhan']);

        // Filter theo lớp học phần
        if ($request->filled('lop_hoc_phan_id')) {
            $query->whereHas('lichHoc', function ($q) use ($request) {
                $q->where('lop_hoc_phan_id', $request->lop_hoc_phan_id);
            });
        }

        // Filter theo sinh viên
        if ($request->filled('sinh_vien_id')) {
            $query->where('sinh_vien_id', $request->sinh_vien_id);
        }

        // Filter theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $danhSachDiemDanh = $query->orderBy('ngay_diem_danh', 'desc')->paginate(20);

        // Thống kê tổng quan
        $tongSoBuoi = $query->count();
        $coMat = DiemDanh::where('trang_thai', 'co_mat')->count();
        $vang = DiemDanh::where('trang_thai', 'vang')->count();
        $diTre = DiemDanh::where('trang_thai', 'di_tre')->count();

        $danhSachLopHocPhan = LopHocPhan::orderBy('ma_lop_hp')->get();
        $danhSachSinhVien = SinhVien::orderBy('ma_sinh_vien')->get();

        return view('diem-danh.thong-ke', compact(
            'danhSachDiemDanh',
            'danhSachLopHocPhan',
            'danhSachSinhVien',
            'tongSoBuoi',
            'coMat',
            'vang',
            'diTre'
        ));
    }
}

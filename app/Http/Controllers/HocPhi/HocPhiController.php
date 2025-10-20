<?php

namespace App\Http\Controllers\HocPhi;

use App\Http\Controllers\Controller;
use App\Models\HocPhi\HocPhi;
use App\Models\NhanSu\SinhVien;
use App\Models\HeThong\HocKy;
use Illuminate\Http\Request;

class HocPhiController extends Controller
{
    /**
     * Hiển thị danh sách học phí
     */
    public function index(Request $request)
    {
        $query = HocPhi::with(['sinhVien', 'hocKy']);

        // Filter theo sinh viên
        if ($request->filled('sinh_vien_id')) {
            $query->where('sinh_vien_id', $request->sinh_vien_id);
        }

        // Filter theo học kỳ
        if ($request->filled('hoc_ky_id')) {
            $query->where('hoc_ky_id', $request->hoc_ky_id);
        }

        // Filter theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Search theo mã sinh viên hoặc tên
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sinhVien', function ($q) use ($search) {
                $q->where('ma_sinh_vien', 'like', "%$search%")
                    ->orWhere('ho_ten', 'like', "%$search%");
            });
        }

        $danhSachHocPhi = $query->orderBy('created_at', 'desc')->paginate(20);

        // Lấy danh sách học kỳ và sinh viên cho filter
        $danhSachHocKy = HocKy::orderBy('ten_hoc_ky', 'desc')->get();
        $danhSachSinhVien = SinhVien::orderBy('ma_sinh_vien')->get();

        // Thống kê
        $tongHocPhi = HocPhi::sum('so_tien');
        $daNop = HocPhi::where('trang_thai', 'da_nop')->sum('so_tien');
        $chuaNop = HocPhi::where('trang_thai', 'chua_nop')->sum('so_tien');

        return view('hoc-phi.index', compact(
            'danhSachHocPhi',
            'danhSachHocKy',
            'danhSachSinhVien',
            'tongHocPhi',
            'daNop',
            'chuaNop'
        ));
    }

    /**
     * Hiển thị form tạo phiếu thu học phí
     */
    public function create()
    {
        $danhSachSinhVien = SinhVien::orderBy('ma_sinh_vien')->get();
        $danhSachHocKy = HocKy::orderBy('ten_hoc_ky', 'desc')->get();

        return view('hoc-phi.create', compact('danhSachSinhVien', 'danhSachHocKy'));
    }

    /**
     * Lưu phiếu thu học phí mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_vien,id',
            'hoc_ky_id' => 'required|exists:hoc_ky,id',
            'so_tien' => 'required|numeric|min:0',
            'ngay_nop' => 'nullable|date',
            'trang_thai' => 'required|in:chua_nop,da_nop,no',
            'ghi_chu' => 'nullable|string',
        ]);

        HocPhi::create($validated);

        return redirect()->route('hoc-phi.index')
            ->with('success', 'Đã tạo phiếu thu học phí thành công!');
    }

    /**
     * Hiển thị chi tiết học phí
     */
    public function show($id)
    {
        $hocPhi = HocPhi::with(['sinhVien', 'hocKy'])->findOrFail($id);

        return view('hoc-phi.show', compact('hocPhi'));
    }

    /**
     * Hiển thị form cập nhật học phí
     */
    public function edit($id)
    {
        $hocPhi = HocPhi::findOrFail($id);
        $danhSachSinhVien = SinhVien::orderBy('ma_sinh_vien')->get();
        $danhSachHocKy = HocKy::orderBy('ten_hoc_ky', 'desc')->get();

        return view('hoc-phi.edit', compact('hocPhi', 'danhSachSinhVien', 'danhSachHocKy'));
    }

    /**
     * Cập nhật thông tin học phí
     */
    public function update(Request $request, $id)
    {
        $hocPhi = HocPhi::findOrFail($id);

        $validated = $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_vien,id',
            'hoc_ky_id' => 'required|exists:hoc_ky,id',
            'so_tien' => 'required|numeric|min:0',
            'ngay_nop' => 'nullable|date',
            'trang_thai' => 'required|in:chua_nop,da_nop,no',
            'ghi_chu' => 'nullable|string',
        ]);

        $hocPhi->update($validated);

        return redirect()->route('hoc-phi.index')
            ->with('success', 'Đã cập nhật học phí thành công!');
    }

    /**
     * Xóa phiếu thu học phí
     */
    public function destroy($id)
    {
        $hocPhi = HocPhi::findOrFail($id);
        $hocPhi->delete();

        return redirect()->route('hoc-phi.index')
            ->with('success', 'Đã xóa phiếu thu học phí thành công!');
    }
}

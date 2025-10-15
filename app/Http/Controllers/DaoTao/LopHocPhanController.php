<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LopHocPhan;
use App\Models\MonHoc;
use App\Models\HocKy;

class LopHocPhanController extends Controller
{
    /**
     * Hiển thị danh sách lớp học phần
     */
    public function index(Request $request)
    {
        // Lọc dữ liệu
        $query = \App\Models\DaoTao\LopHocPhan::query()->with(['monHoc', 'hocKy']);

        if ($request->filled('search')) {
            $query->where('ma_lop_hp', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('mon_hoc_id')) {
            $query->where('mon_hoc_id', $request->mon_hoc_id);
        }

        if ($request->filled('hoc_ky_id')) {
            $query->where('hoc_ky_id', $request->hoc_ky_id);
        }

        if ($request->filled('trang_thai_lop')) {
            $query->where('trang_thai_lop', $request->trang_thai_lop);
        }

        $lopHocPhans = $query->orderBy('id', 'DESC')->paginate(10);
        $monHocs = \App\Models\DaoTao\MonHoc::all();
        $hocKys = \App\Models\HeThong\HocKy::all();

        return view('dao-tao.lop-hoc-phan.index', compact('lopHocPhans', 'monHocs', 'hocKys'));
    }

    /**
     * Hiển thị form thêm mới lớp học phần
     */
    public function create()
    {
        $monHocs = \App\Models\DaoTao\MonHoc::all();
        $hocKys = \App\Models\HeThong\HocKy::all();

        return view('dao-tao.lop-hoc-phan.create', compact('monHocs', 'hocKys'));
    }

    /**
     * Lưu lớp học phần mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma_lop_hp' => 'required|unique:lop_hoc_phan,ma_lop_hp',
            'mon_hoc_id' => 'required|exists:mon_hoc,id',
            'hoc_ky_id' => 'required|exists:hoc_ky,id',
            'hinh_thuc' => 'required|in:offline,online,hybrid',
            'trang_thai_lop' => 'required|in:mo_dang_ky,dang_hoc,ket_thuc,huy',
        ]);

        \App\Models\DaoTao\LopHocPhan::create($request->all());

        return redirect()->route('dao-tao.lop-hoc-phan.index')
            ->with('success', 'Thêm lớp học phần thành công!');
    }

    /**
     * Hiển thị chi tiết lớp học phần
     */
    public function show($id)
    {
        $lopHocPhan = \App\Models\DaoTao\LopHocPhan::with(['monHoc', 'hocKy'])->findOrFail($id);

        return view('dao-tao.lop-hoc-phan.show', compact('lopHocPhan'));
    }

    /**
     * Hiển thị form sửa lớp học phần
     */
    public function edit($id)
    {
        $lopHocPhan = \App\Models\DaoTao\LopHocPhan::findOrFail($id);
        $monHocs = \App\Models\DaoTao\MonHoc::all();
        $hocKys = \App\Models\HeThong\HocKy::all();

        return view('dao-tao.lop-hoc-phan.edit', compact('lopHocPhan', 'monHocs', 'hocKys'));
    }

    /**
     * Cập nhật lớp học phần
     */
    public function update(Request $request, $id)
    {
        $lopHocPhan = \App\Models\DaoTao\LopHocPhan::findOrFail($id);

        $request->validate([
            'ma_lop_hp' => 'required|unique:lop_hoc_phan,ma_lop_hp,' . $lopHocPhan->id,
            'mon_hoc_id' => 'required|exists:mon_hoc,id',
            'hoc_ky_id' => 'required|exists:hoc_ky,id',
            'hinh_thuc' => 'required|in:offline,online,hybrid',
            'trang_thai_lop' => 'required|in:mo_dang_ky,dang_hoc,ket_thuc,huy',
        ]);

        $lopHocPhan->update($request->all());

        return redirect()->route('dao-tao.lop-hoc-phan.index')
            ->with('success', 'Cập nhật lớp học phần thành công!');
    }

    /**
     * Xóa lớp học phần
     */
    public function destroy($id)
    {
        $lopHocPhan = \App\Models\DaoTao\LopHocPhan::findOrFail($id);
        $lopHocPhan->delete();

        return redirect()->route('dao-tao.lop-hoc-phan.index')
            ->with('success', 'Xóa lớp học phần thành công!');
    }
}

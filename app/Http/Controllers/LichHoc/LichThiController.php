<?php

namespace App\Http\Controllers\LichHoc;

use App\Http\Controllers\Controller;
use App\Models\LichHoc\LopHocPhan;
use App\Models\LichHoc\PhongHoc;
use App\Models\LichHoc\LichThi;
use App\Models\NhanSu\GiangVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LichThiController extends Controller
{
    public function index(Request $request)
    {
        $query = LichThi::with(['lopHocPhan.monHoc', 'phongHoc']);

        if ($request->filled('search')) {
            $query->whereHas('lopHocPhan', function ($q) use ($request) {
                $q->where('ma_lop_hp', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('hinh_thuc')) {
            $query->where('hinh_thuc', $request->hinh_thuc);
        }

        if ($request->filled('ngay_thi')) {
            $query->whereDate('ngay_thi', $request->ngay_thi);
        }

        $lichThis = $query->paginate(10);
        return view('dao-tao.lich-thi.index', compact('lichThis'));
    }


    public function create()
    {
        $lopHocPhans = LopHocPhan::with('monHoc')->get();
        $phongHocs = PhongHoc::all();
        return view('dao-tao.lich-thi.create', compact('lopHocPhans', 'phongHocs'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'lop_hoc_phan_id' => 'required|exists:lop_hoc_phan,id',
            'ngay_thi' => 'required|date',
            'gio_bat_dau' => ['required', 'date_format:H:i'],
            'gio_ket_thuc' => ['required', 'date_format:H:i', 'after:gio_bat_dau'],
            'phong_hoc_id' => 'required|exists:phong_hoc,id',
            'hinh_thuc' => 'required|in:offline,online,hybrid',
            'link_online' => 'nullable|string|max:255',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240', // tối đa 10MB
        ]);

        $lichThi = new LichThi();
        $lichThi->lop_hoc_phan_id = $data['lop_hoc_phan_id'];
        $lichThi->ngay_thi = $data['ngay_thi'];
        $lichThi->gio_bat_dau = $data['gio_bat_dau'];
        $lichThi->gio_ket_thuc = $data['gio_ket_thuc'];
        $lichThi->phong_hoc_id = $data['phong_hoc_id'];
        $lichThi->hinh_thuc = $data['hinh_thuc'];
        $lichThi->link_online = $data['link_online'] ?? null;
        $lichThi->ngay_gui = Carbon::now(); // tự động thời gian hiện tại

        // Xử lý upload file PDF nếu có
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('lich-thi', $fileName, 'public');
            $lichThi->file_pdf = $path;
        }

        $lichThi->save();

        return redirect()
            ->route('dao-tao.lich-thi.index')
            ->with('success', 'Thêm lịch thi thành công!');
    }

    /**
     * Hiển thị chi tiết lịch thi
     */
    public function show($id)
    {
        $lichThi = LichThi::with(['lopHocPhan.monHoc', 'phongHoc'])->findOrFail($id);
        return view('dao-tao.lich-thi.show', compact('lichThi'));
    }

    /**
     * Hiển thị form chỉnh sửa lịch thi
     */
    public function edit($id)
    {
        $lichThi = LichThi::findOrFail($id);
        $lopHocPhan = LopHocPhan::all();
        $phongHoc = PhongHoc::all();
        return view('dao-tao.lich-thi.edit', compact('lichThi', 'lopHocPhan', 'phongHoc'));
    }

    /**
     * Cập nhật lịch thi
     */

    public function update(Request $request, $id)
    {
        $lichThi = LichThi::findOrFail($id);

        // Chuẩn hóa giờ về định dạng H:i nếu có giây
        if ($request->gio_bat_dau && strlen($request->gio_bat_dau) === 8) {
            $request->merge(['gio_bat_dau' => substr($request->gio_bat_dau, 0, 5)]);
        }
        if ($request->gio_ket_thuc && strlen($request->gio_ket_thuc) === 8) {
            $request->merge(['gio_ket_thuc' => substr($request->gio_ket_thuc, 0, 5)]);
        }

        $data = $request->validate([
            'lop_hoc_phan_id' => 'required|exists:lop_hoc_phan,id',
            'ngay_thi' => 'required|date',
            'gio_bat_dau' => ['required', 'date_format:H:i'],
            'gio_ket_thuc' => ['required', 'date_format:H:i', 'after:gio_bat_dau'],
            'phong_hoc_id' => 'required|exists:phong_hoc,id',
            'hinh_thuc' => 'required|in:offline,online,hybrid',
            'link_online' => 'nullable|string|max:255',
        ]);

        $lichThi->update($data);

        return redirect()
            ->route('dao-tao.lich-thi.index')
            ->with('success', 'Cập nhật lịch thi thành công');
    }


    /**
     * Xóa lịch thi
     */
    public function destroy($id)
    {
        LichThi::destroy($id);
        return redirect()->route('dao-tao.lich-thi.index')->with('success', 'Xóa lịch thi thành công');
    }
}

<?php

namespace App\Http\Controllers\LichHoc;

use App\Http\Controllers\Controller;
use App\Models\LichHoc\LichHoc;
use App\Models\LichHoc\LopHocPhan;
use App\Models\LichHoc\PhongHoc;
use App\Models\NhanSu\GiangVien;
use Illuminate\Http\Request;

class LichHocController extends Controller
{
    public function index(Request $request)
    {
        $query = LichHoc::with(['lopHocPhan', 'phongHoc', 'giangVien']);

        //  Tìm kiếm theo mã lớp học phần, môn học hoặc ghi chú
        if ($search = $request->input('search')) {
            $query->whereHas('lopHocPhan', function ($q) use ($search) {
                $q->where('ma_lop_hp', 'like', "%{$search}%")
                    ->orWhereHas('monHoc', function ($q2) use ($search) {
                        $q2->where('ten_mon', 'like', "%{$search}%");
                    });
            })
                ->orWhere('ghi_chu', 'like', "%{$search}%");
        }

        //  Lọc theo ngày học
        if ($ngay = $request->input('ngay')) {
            $query->whereDate('ngay', $ngay);
        }


        //  Lọc theo hình thức học
        if ($hinhThuc = $request->input('hinh_thuc_buoi_hoc')) {
            $query->where('hinh_thuc_buoi_hoc', $hinhThuc);
        }

        // Phân trang
        $lichHoc = $query->orderBy('ngay', 'asc')->paginate(10);

        // Lấy danh sách giảng viên cho bộ lọc
        $giangViens = GiangVien::select('id', 'ho_ten')->get();

        return view('dao-tao.lich-hoc.index', compact('lichHoc', 'giangViens'));
    }



    public function create()
    {
        $lopHocPhans = LopHocPhan::all();
        $phongHocs = PhongHoc::all();
        $giangViens = GiangVien::all();
        return view('dao-tao.lich-hoc.create', compact('lopHocPhans', 'phongHocs', 'giangViens'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lop_hoc_phan_id' => 'required|exists:lop_hoc_phan,id',
            'ngay' => 'required|date|after_or_equal:today',
            'gio_bat_dau' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'gio_ket_thuc' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/', 'after:gio_bat_dau'],
            'phong_hoc_id' => 'required|exists:phong_hoc,id',
            'hinh_thuc_buoi_hoc' => 'required|in:offline,online,hybrid',
            'link_online' => 'nullable|string|max:255|required_if:hinh_thuc_buoi_hoc,online,hybrid',
            'giang_vien_phu_trach' => 'required|exists:giang_vien,id',
            'ghi_chu' => 'nullable|string|max:500',
        ]);

        // Kiểm tra trùng phòng học
        $trungPhong = LichHoc::where('phong_hoc_id', $data['phong_hoc_id'])
            ->where('ngay', $data['ngay'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('gio_bat_dau', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhereBetween('gio_ket_thuc', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('gio_bat_dau', '<=', $data['gio_bat_dau'])
                            ->where('gio_ket_thuc', '>=', $data['gio_ket_thuc']);
                    });
            })
            ->exists();

        if ($trungPhong) {
            return back()->withErrors(['phong_hoc_id' => 'Phòng học đã được sử dụng trong khung giờ này!'])->withInput();
        }

        // Kiểm tra giảng viên không bị trùng lịch
        $trungGiangVien = LichHoc::where('giang_vien_phu_trach', $data['giang_vien_phu_trach'])
            ->where('ngay', $data['ngay'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('gio_bat_dau', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhereBetween('gio_ket_thuc', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('gio_bat_dau', '<=', $data['gio_bat_dau'])
                            ->where('gio_ket_thuc', '>=', $data['gio_ket_thuc']);
                    });
            })
            ->exists();

        if ($trungGiangVien) {
            return back()->withErrors(['giang_vien_phu_trach' => 'Giảng viên đã có lịch dạy trùng giờ!'])->withInput();
        }

        LichHoc::create($data);
        return redirect()->route('dao-tao.lich-hoc.index')->with('success', 'Thêm lịch học thành công!');
    }

    public function show($id)
    {
        $lichHoc = LichHoc::with(['lopHocPhan.monHoc', 'phongHoc', 'giangVien'])->findOrFail($id);
        return view('dao-tao.lich-hoc.show', compact('lichHoc'));
    }

    public function edit($id)
    {
        $lichHoc = LichHoc::findOrFail($id);
        $lopHocPhans = LopHocPhan::with('monHoc')->get();
        $phongHocs = PhongHoc::all();
        $giangViens = GiangVien::all();
        return view('dao-tao.lich-hoc.edit', compact('lichHoc', 'lopHocPhans', 'phongHocs', 'giangViens'));
    }

    public function update(Request $request, $id)
    {
        $lichHoc = LichHoc::findOrFail($id);

        $data = $request->validate([
            'lop_hoc_phan_id' => 'required|exists:lop_hoc_phan,id',
            'ngay' => 'required|date',
            'gio_bat_dau' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'gio_ket_thuc' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/', 'after:gio_bat_dau'],
            'phong_hoc_id' => 'required|exists:phong_hoc,id',
            'hinh_thuc_buoi_hoc' => 'required|in:offline,online,hybrid',
            'link_online' => 'nullable|string|max:255|required_if:hinh_thuc_buoi_hoc,online,hybrid',
            'giang_vien_phu_trach' => 'required|exists:giang_vien,id',
            'ghi_chu' => 'nullable|string|max:500',
        ]);

        // Kiểm tra trùng phòng học (ngoại trừ bản ghi hiện tại)
        $trungPhong = LichHoc::where('phong_hoc_id', $data['phong_hoc_id'])
            ->where('ngay', $data['ngay'])
            ->where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->whereBetween('gio_bat_dau', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhereBetween('gio_ket_thuc', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('gio_bat_dau', '<=', $data['gio_bat_dau'])
                            ->where('gio_ket_thuc', '>=', $data['gio_ket_thuc']);
                    });
            })
            ->exists();

        if ($trungPhong) {
            return back()->withErrors(['phong_hoc_id' => 'Phòng học đã được sử dụng trong khung giờ này!'])->withInput();
        }

        // Kiểm tra giảng viên không bị trùng lịch (ngoại trừ bản ghi hiện tại)
        $trungGiangVien = LichHoc::where('giang_vien_phu_trach', $data['giang_vien_phu_trach'])
            ->where('ngay', $data['ngay'])
            ->where('id', '!=', $id)
            ->where(function ($query) use ($data) {
                $query->whereBetween('gio_bat_dau', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhereBetween('gio_ket_thuc', [$data['gio_bat_dau'], $data['gio_ket_thuc']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('gio_bat_dau', '<=', $data['gio_bat_dau'])
                            ->where('gio_ket_thuc', '>=', $data['gio_ket_thuc']);
                    });
            })
            ->exists();

        if ($trungGiangVien) {
            return back()->withErrors(['giang_vien_phu_trach' => 'Giảng viên đã có lịch dạy trùng giờ!'])->withInput();
        }

        $lichHoc->update($data);

        return redirect()->route('dao-tao.lich-hoc.index')->with('success', 'Cập nhật lịch học thành công');
    }

    public function destroy($id)
    {
        LichHoc::destroy($id);
        return redirect()->route('dao-tao.lich-hoc.index')->with('success', 'Xóa lịch học thành công');
    }
}

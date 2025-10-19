<?php

namespace App\Http\Controllers\LichHoc;

use App\Models\LichHoc\LopHocPhan;
use App\Http\Controllers\Controller;
use App\Models\DaoTao\MonHoc;
use App\Models\HeThong\HocKy;
use Illuminate\Http\Request;

class LopHocPhanController extends Controller
{
    public function index(Request $request)
    {
        $query = LopHocPhan::with(['monHoc', 'hocKy']);

        // Keyword search: mã lớp, tên môn
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ma_lop_hp', 'like', "%{$search}%")
                  ->orWhereHas('monHoc', function ($mq) use ($search) {
                      $mq->where('ten_mon', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by hoc_ky
        if ($hocKyId = $request->query('hoc_ky_id')) {
            $query->where('hoc_ky_id', $hocKyId);
        }

        // Filter by trang_thai (map UI small values to enum values if needed)
        if ($trangThai = $request->query('trang_thai')) {
            // example mapping: 'mo' => 'mo_dang_ky', 'dong' => 'ket_thuc' (adjust as needed)
            if ($trangThai === 'mo') {
                $query->where('trang_thai_lop', 'mo_dang_ky');
            } elseif ($trangThai === 'dong') {
                $query->where('trang_thai_lop', 'ket_thuc');
            }
        }

        $lopHocPhans = $query->orderBy('id')->paginate(10)->withQueryString();
        $hocKys = HocKy::all();
        return view('dao-tao.lop-hoc-phan.index', compact('lopHocPhans', 'hocKys'));
    }
    public function show($id)
    {
        $lopHocPhan = LopHocPhan::with(['monHoc', 'hocKy'])->findOrFail($id);
        return view('dao-tao.lop-hoc-phan.show', compact('lopHocPhan'));
    }
    public function create()
    {
        $monHocs = MonHoc::all();
        $hocKys = HocKy::all();
        return view('dao-tao.lop-hoc-phan.create', compact('monHocs', 'hocKys'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ma_lop_hp' => 'required|string|max:50|unique:lop_hoc_phan,ma_lop_hp',
            'mon_hoc_id' => 'required|exists:mon_hoc,id',
            'hoc_ky_id' => 'required|exists:hoc_ky,id',
            'suc_chua' => 'nullable|integer|min:1',
            'hinh_thuc' => 'required|in:offline,online,hybrid',
            'link_online' => 'nullable|string|max:255',
            'ghi_chu' => 'nullable|string',
            'trang_thai_lop' => 'required|in:mo_dang_ky,dang_hoc,ket_thuc,huy',
        ]);

        $lopHocPhan = new LopHocPhan();
        $lopHocPhan->ma_lop_hp = $data['ma_lop_hp'];
        $lopHocPhan->mon_hoc_id = $data['mon_hoc_id'];
        $lopHocPhan->hoc_ky_id = $data['hoc_ky_id'];
        $lopHocPhan->suc_chua = $data['suc_chua'] ?? null;
        $lopHocPhan->hinh_thuc = $data['hinh_thuc'];
        $lopHocPhan->link_online = $data['link_online'] ?? null;
        $lopHocPhan->ghi_chu = $data['ghi_chu'] ?? null;
        $lopHocPhan->trang_thai_lop = $data['trang_thai_lop'];
        $lopHocPhan->save();

        return redirect()->route('dao-tao.lop-hoc-phan.index')->with('success', 'Thêm lớp học phần thành công!');
    }

    public function edit($id)
    {
        $lopHocPhan = LopHocPhan::findOrFail($id);
        $monHocs = MonHoc::all();
        $hocKys = HocKy::all();
        return view('dao-tao.lop-hoc-phan.edit', compact('lopHocPhan', 'monHocs', 'hocKys'));
    }

    public function update(Request $request, $id)
    {
        $lopHocPhan = LopHocPhan::findOrFail($id);
        $data = $request->validate([
            'ma_lop_hp' => 'required|string|max:50|unique:lop_hoc_phan,ma_lop_hp,' . $lopHocPhan->id,
            'mon_hoc_id' => 'required|exists:mon_hoc,id',
            'hoc_ky_id' => 'required|exists:hoc_ky,id',
            'suc_chua' => 'nullable|integer|min:1',
            'hinh_thuc' => 'required|in:offline,online,hybrid',
            'link_online' => 'nullable|string|max:255',
            'ghi_chu' => 'nullable|string',
            'trang_thai_lop' => 'required|in:mo_dang_ky,dang_hoc,ket_thuc,huy',
        ]);

        $lopHocPhan->ma_lop_hp = $data['ma_lop_hp'];
        $lopHocPhan->mon_hoc_id = $data['mon_hoc_id'];
        $lopHocPhan->hoc_ky_id = $data['hoc_ky_id'];
        $lopHocPhan->suc_chua = $data['suc_chua'] ?? null;
        $lopHocPhan->hinh_thuc = $data['hinh_thuc'];
        $lopHocPhan->link_online = $data['link_online'] ?? null;
        $lopHocPhan->ghi_chu = $data['ghi_chu'] ?? null;
        $lopHocPhan->trang_thai_lop = $data['trang_thai_lop'];
        $lopHocPhan->save();

        return redirect()->route('dao-tao.lop-hoc-phan.index')->with('success', 'Cập nhật lớp học phần thành công!');
    }

    public function destroy($id)
    {
        LopHocPhan::destroy($id);
        return redirect()->route('dao-tao.lop-hoc-phan.index')->with('success', 'Xóa lớp học phần thành công!');
    }
}

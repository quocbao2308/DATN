<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\DaoTao\Grade;
use App\Models\NhanSu\SinhVien;
use App\Models\DaoTao\MonHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['sinhVien', 'monHoc']);

        if ($request->filled('sinh_vien_id')) {
            $query->where('sinh_vien_id', $request->sinh_vien_id);
        }
        if ($request->filled('mon_hoc_id')) {
            $query->where('mon_hoc_id', $request->mon_hoc_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('sinhVien', fn($q) => $q->where('ho_ten', 'like', "%{$search}%"))
                  ->orWhereHas('monHoc', fn($q) => $q->where('ten_mon', 'like', "%{$search}%"));
        }

        $grades = $query->orderBy('id', 'desc')->paginate(15);
        $sinhViens = SinhVien::orderBy('ho_ten')->get();
        $monHocs = MonHoc::orderBy('ten_mon')->get();

        return view('dao-tao.grades.index', compact('grades', 'sinhViens', 'monHocs'));
    }

    public function create()
    {
        $sinhViens = SinhVien::orderBy('ho_ten')->get();
        $monHocs = MonHoc::orderBy('ten_mon')->get();

        return view('dao-tao.grades.create', compact('sinhViens', 'monHocs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_vien,id',
            'mon_hoc_id' => 'required|exists:mon_hoc,id',
            'diem_qua_trinh' => 'nullable|numeric|min:0|max:10',
            'diem_thi' => 'nullable|numeric|min:0|max:10',
            'diem_tong_ket' => 'nullable|numeric|min:0|max:10',
        ]);

        DB::transaction(function() use ($validated) {
            Grade::create($validated);
        });

        return redirect()->route('dao-tao.grades.index')->with('success', 'Thêm điểm thành công.');
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $sinhViens = SinhVien::orderBy('ho_ten')->get();
        $monHocs = MonHoc::orderBy('ten_mon')->get();

        return view('dao-tao.grades.edit', compact('grade', 'sinhViens', 'monHocs'));
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $validated = $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_vien,id',
            'mon_hoc_id' => 'required|exists:mon_hoc,id',
            'diem_qua_trinh' => 'nullable|numeric|min:0|max:10',
            'diem_thi' => 'nullable|numeric|min:0|max:10',
            'diem_tong_ket' => 'nullable|numeric|min:0|max:10',
        ]);

        DB::transaction(function() use ($grade, $validated) {
            $grade->update($validated);
        });

        return redirect()->route('dao-tao.grades.index')->with('success', 'Cập nhật điểm thành công.');
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);

        DB::transaction(function() use ($grade) {
            $grade->delete();
        });

        return redirect()->route('dao-tao.grades.index')->with('success', 'Xóa điểm thành công.');
    }
}
// Ghí chsu quản lý đểm 
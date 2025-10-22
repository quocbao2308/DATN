<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\HeThong\KhoaHoc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KhoaHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $khoaHocs = KhoaHoc::withCount('sinhViens')
            ->orderBy('nam_bat_dau', 'desc')
            ->paginate(15);

        return view('dao-tao.khoa-hoc.index', compact('khoaHocs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dao-tao.khoa-hoc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_khoa_hoc' => 'required|string|max:100|unique:khoa_hoc,ten_khoa_hoc',
            'nam_bat_dau' => 'required|integer|min:2000|max:2100',
            'nam_ket_thuc' => 'required|integer|min:2000|max:2100|gt:nam_bat_dau',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'ten_khoa_hoc.required' => 'Tên khóa học không được để trống',
            'ten_khoa_hoc.unique' => 'Tên khóa học đã tồn tại',
            'nam_bat_dau.required' => 'Năm bắt đầu không được để trống',
            'nam_bat_dau.integer' => 'Năm bắt đầu phải là số nguyên',
            'nam_bat_dau.min' => 'Năm bắt đầu phải từ 2000 trở lên',
            'nam_ket_thuc.required' => 'Năm kết thúc không được để trống',
            'nam_ket_thuc.gt' => 'Năm kết thúc phải lớn hơn năm bắt đầu',
        ]);

        KhoaHoc::create($validated);

        return redirect()->route('dao-tao.khoa-hoc.index')
            ->with('success', 'Thêm khóa học thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $khoaHoc = KhoaHoc::withCount('sinhViens')->findOrFail($id);
        return view('dao-tao.khoa-hoc.show', compact('khoaHoc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $khoaHoc = KhoaHoc::findOrFail($id);
        return view('dao-tao.khoa-hoc.edit', compact('khoaHoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $khoaHoc = KhoaHoc::findOrFail($id);

        $validated = $request->validate([
            'ten_khoa_hoc' => [
                'required',
                'string',
                'max:100',
                Rule::unique('khoa_hoc', 'ten_khoa_hoc')->ignore($khoaHoc->id)
            ],
            'nam_bat_dau' => 'required|integer|min:2000|max:2100',
            'nam_ket_thuc' => 'required|integer|min:2000|max:2100|gt:nam_bat_dau',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'ten_khoa_hoc.required' => 'Tên khóa học không được để trống',
            'ten_khoa_hoc.unique' => 'Tên khóa học đã tồn tại',
            'nam_bat_dau.required' => 'Năm bắt đầu không được để trống',
            'nam_ket_thuc.gt' => 'Năm kết thúc phải lớn hơn năm bắt đầu',
        ]);

        $khoaHoc->update($validated);

        return redirect()->route('dao-tao.khoa-hoc.index')
            ->with('success', 'Cập nhật khóa học thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $khoaHoc = KhoaHoc::withCount('sinhViens')->findOrFail($id);

        if ($khoaHoc->sinh_viens_count > 0) {
            return redirect()->route('dao-tao.khoa-hoc.index')
                ->with('error', 'Không thể xóa khóa học đã có sinh viên');
        }

        $khoaHoc->delete();

        return redirect()->route('dao-tao.khoa-hoc.index')
            ->with('success', 'Xóa khóa học thành công');
    }
}

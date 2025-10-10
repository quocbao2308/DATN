<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\HocKy;
use App\Models\System\KhoaHoc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HocKyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hocKys = HocKy::with('khoaHoc')
            ->orderBy('khoa_hoc_id', 'desc')
            ->orderBy('hoc_ky', 'asc')
            ->paginate(15);

        return view('admin.hoc-ky.index', compact('hocKys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $khoaHocs = KhoaHoc::orderBy('nam_bat_dau', 'desc')->get();
        return view('admin.hoc-ky.create', compact('khoaHocs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
            'hoc_ky' => [
                'required',
                'integer',
                'min:1',
                'max:10',
                Rule::unique('hoc_ky')->where(function ($query) use ($request) {
                    return $query->where('khoa_hoc_id', $request->khoa_hoc_id);
                })
            ],
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'khoa_hoc_id.required' => 'Khóa học không được để trống',
            'khoa_hoc_id.exists' => 'Khóa học không tồn tại',
            'hoc_ky.required' => 'Học kỳ không được để trống',
            'hoc_ky.unique' => 'Học kỳ này đã tồn tại trong khóa học',
            'ngay_bat_dau.required' => 'Ngày bắt đầu không được để trống',
            'ngay_ket_thuc.required' => 'Ngày kết thúc không được để trống',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ]);

        HocKy::create($validated);

        return redirect()->route('admin.hoc-ky.index')
            ->with('success', 'Thêm học kỳ thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hocKy = HocKy::with('khoaHoc')->findOrFail($id);
        return view('admin.hoc-ky.show', compact('hocKy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hocKy = HocKy::findOrFail($id);
        $khoaHocs = KhoaHoc::orderBy('nam_bat_dau', 'desc')->get();
        return view('admin.hoc-ky.edit', compact('hocKy', 'khoaHocs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hocKy = HocKy::findOrFail($id);

        $validated = $request->validate([
            'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
            'hoc_ky' => [
                'required',
                'integer',
                'min:1',
                'max:10',
                Rule::unique('hoc_ky')->where(function ($query) use ($request) {
                    return $query->where('khoa_hoc_id', $request->khoa_hoc_id);
                })->ignore($hocKy->id)
            ],
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'khoa_hoc_id.required' => 'Khóa học không được để trống',
            'hoc_ky.unique' => 'Học kỳ này đã tồn tại trong khóa học',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu',
        ]);

        $hocKy->update($validated);

        return redirect()->route('admin.hoc-ky.index')
            ->with('success', 'Cập nhật học kỳ thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hocKy = HocKy::findOrFail($id);
        $hocKy->delete();

        return redirect()->route('admin.hoc-ky.index')
            ->with('success', 'Xóa học kỳ thành công');
    }
}

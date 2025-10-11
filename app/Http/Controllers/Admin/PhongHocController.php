<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LichHoc\PhongHoc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhongHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phongHocs = PhongHoc::orderBy('ma_phong', 'asc')
            ->paginate(15);

        return view('admin.phong-hoc.index', compact('phongHocs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.phong-hoc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_phong' => 'required|string|max:50|unique:phong_hoc,ma_phong',
            'ten_phong' => 'required|string|max:255',
            'suc_chua' => 'required|integer|min:1|max:1000',
            'vi_tri' => 'nullable|string|max:255',
            'loai_phong' => 'nullable|in:Lý thuyết,Thực hành,Hội trường,Phòng máy',
            'trang_thai' => 'required|in:Hoạt động,Bảo trì,Không sử dụng',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'ma_phong.required' => 'Mã phòng không được để trống',
            'ma_phong.unique' => 'Mã phòng đã tồn tại',
            'ten_phong.required' => 'Tên phòng không được để trống',
            'suc_chua.required' => 'Sức chứa không được để trống',
            'suc_chua.min' => 'Sức chứa phải ít nhất là 1',
            'suc_chua.max' => 'Sức chứa không được vượt quá 1000',
            'trang_thai.required' => 'Trạng thái không được để trống',
        ]);

        PhongHoc::create($validated);

        return redirect()->route('admin.phong-hoc.index')
            ->with('success', 'Thêm phòng học thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $phongHoc = PhongHoc::findOrFail($id);
        return view('admin.phong-hoc.show', compact('phongHoc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $phongHoc = PhongHoc::findOrFail($id);
        return view('admin.phong-hoc.edit', compact('phongHoc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $phongHoc = PhongHoc::findOrFail($id);

        $validated = $request->validate([
            'ma_phong' => [
                'required',
                'string',
                'max:50',
                Rule::unique('phong_hoc', 'ma_phong')->ignore($phongHoc->id)
            ],
            'ten_phong' => 'required|string|max:255',
            'suc_chua' => 'required|integer|min:1|max:1000',
            'vi_tri' => 'nullable|string|max:255',
            'loai_phong' => 'nullable|in:Lý thuyết,Thực hành,Hội trường,Phòng máy',
            'trang_thai' => 'required|in:Hoạt động,Bảo trì,Không sử dụng',
            'mo_ta' => 'nullable|string|max:500',
        ], [
            'ma_phong.required' => 'Mã phòng không được để trống',
            'ma_phong.unique' => 'Mã phòng đã tồn tại',
            'ten_phong.required' => 'Tên phòng không được để trống',
            'suc_chua.required' => 'Sức chứa không được để trống',
            'trang_thai.required' => 'Trạng thái không được để trống',
        ]);

        $phongHoc->update($validated);

        return redirect()->route('admin.phong-hoc.index')
            ->with('success', 'Cập nhật phòng học thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phongHoc = PhongHoc::findOrFail($id);

        // Kiểm tra có lịch học không
        if ($phongHoc->lichHocs()->count() > 0) {
            return redirect()
                ->route('admin.phong-hoc.index')
                ->with('error', 'Không thể xóa phòng này vì đang có lịch học!');
        }

        // Kiểm tra có lịch thi không
        if ($phongHoc->lichThis()->count() > 0) {
            return redirect()
                ->route('admin.phong-hoc.index')
                ->with('error', 'Không thể xóa phòng này vì đang có lịch thi!');
        }

        $phongHoc->delete();

        return redirect()->route('admin.phong-hoc.index')
            ->with('success', 'Xóa phòng học thành công');
    }
}

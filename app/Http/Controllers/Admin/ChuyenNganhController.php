<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Academic\{ChuyenNganh, Nganh};
use App\Models\System\Khoa;
use Illuminate\Http\Request;

class ChuyenNganhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chuyenNganhs = ChuyenNganh::with(['nganh.khoa'])
            ->withCount('sinhViens')
            ->latest()
            ->paginate(15);

        return view('admin.chuyen-nganh.index', compact('chuyenNganhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $khoas = Khoa::with('nganhs')->orderBy('ten_khoa')->get();
        $nganhs = Nganh::with('khoa')->orderBy('ten_nganh')->get();
        return view('admin.chuyen-nganh.create', compact('khoas', 'nganhs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_chuyen_nganh' => 'required|string|max:255',
            'nganh_id' => 'required|exists:nganh,id',
        ], [
            'ten_chuyen_nganh.required' => 'Tên chuyên ngành không được để trống',
            'nganh_id.required' => 'Vui lòng chọn ngành',
            'nganh_id.exists' => 'Ngành không tồn tại',
        ]);

        ChuyenNganh::create($validated);

        return redirect()
            ->route('admin.chuyen-nganh.index')
            ->with('success', 'Thêm chuyên ngành mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChuyenNganh $chuyenNganh)
    {
        $chuyenNganh->load(['nganh.khoa', 'sinhViens']);
        return view('admin.chuyen-nganh.show', compact('chuyenNganh'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChuyenNganh $chuyenNganh)
    {
        $khoas = Khoa::with('nganhs')->orderBy('ten_khoa')->get();
        $nganhs = Nganh::with('khoa')->orderBy('ten_nganh')->get();
        return view('admin.chuyen-nganh.edit', compact('chuyenNganh', 'khoas', 'nganhs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChuyenNganh $chuyenNganh)
    {
        $validated = $request->validate([
            'ten_chuyen_nganh' => 'required|string|max:255',
            'nganh_id' => 'required|exists:nganh,id',
        ], [
            'ten_chuyen_nganh.required' => 'Tên chuyên ngành không được để trống',
            'nganh_id.required' => 'Vui lòng chọn ngành',
            'nganh_id.exists' => 'Ngành không tồn tại',
        ]);

        $chuyenNganh->update($validated);

        return redirect()
            ->route('admin.chuyen-nganh.index')
            ->with('success', 'Cập nhật chuyên ngành thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChuyenNganh $chuyenNganh)
    {
        if ($chuyenNganh->sinhViens()->count() > 0) {
            return redirect()
                ->route('admin.chuyen-nganh.index')
                ->with('error', 'Không thể xóa chuyên ngành này vì đang có sinh viên!');
        }

        $chuyenNganh->delete();

        return redirect()
            ->route('admin.chuyen-nganh.index')
            ->with('success', 'Xóa chuyên ngành thành công!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeThong\Khoa;
use Illuminate\Http\Request;

class KhoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $khoas = Khoa::withCount(['nganhs', 'giangViens'])
            ->latest()
            ->paginate(15);

        return view('admin.khoa.index', compact('khoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.khoa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_khoa' => 'required|string|max:255|unique:khoa,ten_khoa',
        ], [
            'ten_khoa.required' => 'Tên khoa không được để trống',
            'ten_khoa.unique' => 'Tên khoa đã tồn tại',
            'ten_khoa.max' => 'Tên khoa không được vượt quá 255 ký tự',
        ]);

        Khoa::create($validated);

        return redirect()
            ->route('admin.khoa.index')
            ->with('success', 'Thêm khoa mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Khoa $khoa)
    {
        $khoa->load(['nganhs', 'giangViens']);

        return view('admin.khoa.show', compact('khoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Khoa $khoa)
    {
        return view('admin.khoa.edit', compact('khoa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Khoa $khoa)
    {
        $validated = $request->validate([
            'ten_khoa' => 'required|string|max:255|unique:khoa,ten_khoa,' . $khoa->id,
        ], [
            'ten_khoa.required' => 'Tên khoa không được để trống',
            'ten_khoa.unique' => 'Tên khoa đã tồn tại',
            'ten_khoa.max' => 'Tên khoa không được vượt quá 255 ký tự',
        ]);

        $khoa->update($validated);

        return redirect()
            ->route('admin.khoa.index')
            ->with('success', 'Cập nhật khoa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Khoa $khoa)
    {
        // Kiểm tra xem khoa có ngành nào không
        if ($khoa->nganhs()->count() > 0) {
            return redirect()
                ->route('admin.khoa.index')
                ->with('error', 'Không thể xóa khoa này vì đang có ngành liên kết!');
        }

        // Kiểm tra xem khoa có giảng viên nào không
        if ($khoa->giangViens()->count() > 0) {
            return redirect()
                ->route('admin.khoa.index')
                ->with('error', 'Không thể xóa khoa này vì đang có giảng viên!');
        }

        $khoa->delete();

        return redirect()
            ->route('admin.khoa.index')
            ->with('success', 'Xóa khoa thành công!');
    }
}

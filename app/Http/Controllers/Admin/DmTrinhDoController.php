<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeThong\DmTrinhDo;
use Illuminate\Http\Request;

class DmTrinhDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trinhDos = DmTrinhDo::withCount('giangViens')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.trinh-do.index', compact('trinhDos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trinh-do.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_trinh_do' => 'required|string|max:255|unique:dm_trinh_do,ten_trinh_do',
        ], [
            'ten_trinh_do.required' => 'Tên trình độ không được để trống',
            'ten_trinh_do.unique' => 'Tên trình độ đã tồn tại',
            'ten_trinh_do.max' => 'Tên trình độ không được vượt quá 255 ký tự',
        ]);

        DmTrinhDo::create($validated);

        return redirect()
            ->route('admin.trinh-do.index')
            ->with('success', 'Thêm trình độ mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DmTrinhDo $trinhDo)
    {
        $trinhDo->load('giangViens');
        return view('admin.trinh-do.show', compact('trinhDo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DmTrinhDo $trinhDo)
    {
        return view('admin.trinh-do.edit', compact('trinhDo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DmTrinhDo $trinhDo)
    {
        $validated = $request->validate([
            'ten_trinh_do' => 'required|string|max:255|unique:dm_trinh_do,ten_trinh_do,' . $trinhDo->id,
        ], [
            'ten_trinh_do.required' => 'Tên trình độ không được để trống',
            'ten_trinh_do.unique' => 'Tên trình độ đã tồn tại',
            'ten_trinh_do.max' => 'Tên trình độ không được vượt quá 255 ký tự',
        ]);

        $trinhDo->update($validated);

        return redirect()
            ->route('admin.trinh-do.index')
            ->with('success', 'Cập nhật trình độ thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DmTrinhDo $trinhDo)
    {
        if ($trinhDo->giangViens()->count() > 0) {
            return redirect()
                ->route('admin.trinh-do.index')
                ->with('error', 'Không thể xóa trình độ này vì đang có giảng viên!');
        }

        $trinhDo->delete();

        return redirect()
            ->route('admin.trinh-do.index')
            ->with('success', 'Xóa trình độ thành công!');
    }
}

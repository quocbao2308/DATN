<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\HeThong\TrangThaiHocTap;
use Illuminate\Http\Request;

class TrangThaiHocTapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trangThais = TrangThaiHocTap::withCount('sinhViens')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('dao-tao.trang-thai-hoc-tap.index', compact('trangThais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dao-tao.trang-thai-hoc-tap.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_trang_thai' => 'required|string|max:255|unique:trang_thai_hoc_tap,ten_trang_thai',
        ], [
            'ten_trang_thai.required' => 'Tên trạng thái không được để trống',
            'ten_trang_thai.unique' => 'Tên trạng thái đã tồn tại',
            'ten_trang_thai.max' => 'Tên trạng thái không được vượt quá 255 ký tự',
        ]);

        TrangThaiHocTap::create($validated);

        return redirect()
            ->route('dao-tao.trang-thai.index')
            ->with('success', 'Thêm trạng thái học tập mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrangThaiHocTap $trangThai)
    {
        $trangThai->load('sinhViens');
        return view('dao-tao.trang-thai-hoc-tap.show', compact('trangThai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrangThaiHocTap $trangThai)
    {
        return view('dao-tao.trang-thai-hoc-tap.edit', compact('trangThai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrangThaiHocTap $trangThai)
    {
        $validated = $request->validate([
            'ten_trang_thai' => 'required|string|max:255|unique:trang_thai_hoc_tap,ten_trang_thai,' . $trangThai->id,
        ], [
            'ten_trang_thai.required' => 'Tên trạng thái không được để trống',
            'ten_trang_thai.unique' => 'Tên trạng thái đã tồn tại',
            'ten_trang_thai.max' => 'Tên trạng thái không được vượt quá 255 ký tự',
        ]);

        $trangThai->update($validated);

        return redirect()
            ->route('dao-tao.trang-thai.index')
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrangThaiHocTap $trangThai)
    {
        if ($trangThai->sinhViens()->count() > 0) {
            return redirect()
                ->route('dao-tao.trang-thai.index')
                ->with('error', 'Không thể xóa trạng thái này vì đang có sinh viên!');
        }

        $trangThai->delete();

        return redirect()
            ->route('dao-tao.trang-thai.index')
            ->with('success', 'Xóa trạng thái thành công!');
    }
}

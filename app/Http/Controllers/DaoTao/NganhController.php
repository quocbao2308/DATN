<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\DaoTao\Nganh;
use App\Models\HeThong\Khoa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NganhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nganhs = Nganh::with('khoa')
            ->withCount(['chuyenNganhs', 'sinhViens'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('dao-tao.nganh.index', compact('nganhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $khoas = Khoa::orderBy('ten_khoa')->get();
        return view('dao-tao.nganh.create', compact('khoas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_nganh' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nganh')->where(function ($query) use ($request) {
                    return $query->where('khoa_id', $request->khoa_id);
                }),
            ],
            'khoa_id' => 'required|exists:khoa,id',
        ], [
            'ten_nganh.required' => 'Tên ngành không được để trống',
            'ten_nganh.unique' => 'Tên ngành đã tồn tại trong khoa này!',
            'khoa_id.required' => 'Vui lòng chọn khoa',
            'khoa_id.exists' => 'Khoa không tồn tại',
        ]);

        Nganh::create($validated);

        return redirect()
            ->route('dao-tao.nganh.index')
            ->with('success', 'Thêm ngành mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nganh $nganh)
    {
        $nganh->load(['khoa', 'chuyenNganhs', 'sinhViens']);
        return view('dao-tao.nganh.show', compact('nganh'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nganh $nganh)
    {
        $khoas = Khoa::orderBy('ten_khoa')->get();
        return view('dao-tao.nganh.edit', compact('nganh', 'khoas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nganh $nganh)
    {
        $validated = $request->validate([
            'ten_nganh' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nganh')->where(function ($query) use ($request) {
                    return $query->where('khoa_id', $request->khoa_id);
                })->ignore($nganh->id),
            ],
            'khoa_id' => 'required|exists:khoa,id',
        ], [
            'ten_nganh.required' => 'Tên ngành không được để trống',
            'ten_nganh.unique' => 'Tên ngành đã tồn tại trong khoa này!',
            'khoa_id.required' => 'Vui lòng chọn khoa',
            'khoa_id.exists' => 'Khoa không tồn tại',
        ]);

        $nganh->update($validated);

        return redirect()
            ->route('dao-tao.nganh.index')
            ->with('success', 'Cập nhật ngành thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nganh $nganh)
    {
        if ($nganh->chuyenNganhs()->count() > 0) {
            return redirect()
                ->route('dao-tao.nganh.index')
                ->with('error', 'Không thể xóa ngành này vì đang có chuyên ngành liên kết!');
        }

        if ($nganh->sinhViens()->count() > 0) {
            return redirect()
                ->route('dao-tao.nganh.index')
                ->with('error', 'Không thể xóa ngành này vì đang có sinh viên!');
        }

        $nganh->delete();

        return redirect()
            ->route('dao-tao.nganh.index')
            ->with('success', 'Xóa ngành thành công!');
    }
}

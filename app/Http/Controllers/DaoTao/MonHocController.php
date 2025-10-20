<?php

namespace App\Http\Controllers\DaoTao;

use App\Constants\SystemConstants;
use App\Http\Controllers\Controller;
use App\Models\DaoTao\MonHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MonHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MonHoc::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ma_mon', 'like', "%{$search}%")
                    ->orWhere('ten_mon', 'like', "%{$search}%");
            });
        }

        // Filter by loai_mon
        if ($request->filled('loai_mon')) {
            $query->where('loai_mon', $request->loai_mon);
        }

        // Filter by hinh_thuc_day
        if ($request->filled('hinh_thuc_day')) {
            $query->where('hinh_thuc_day', $request->hinh_thuc_day);
        }

        // Filter by so_tin_chi
        if ($request->filled('so_tin_chi')) {
            $query->where('so_tin_chi', $request->so_tin_chi);
        }

        $monHocs = $query->orderBy('ma_mon', 'asc')->paginate(15);

        return view('dao-tao.mon-hoc.index', compact('monHocs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allMonHocs = MonHoc::orderBy('ten_mon', 'asc')->get();
        return view('dao-tao.mon-hoc.create', compact('allMonHocs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teachingModes = implode(',', array_keys(SystemConstants::TEACHING_MODES));

        $validated = $request->validate([
            'ma_mon' => 'required|string|max:50|unique:mon_hoc,ma_mon',
            'ten_mon' => 'required|string|max:255',
            'so_tin_chi' => 'required|integer|min:1|max:10',
            'mo_ta' => 'nullable|string|max:1000',
            'loai_mon' => 'required|string|max:100',
            'hinh_thuc_day' => 'required|in:' . $teachingModes,
            'thoi_luong' => 'nullable|integer|min:0',
            'so_buoi' => 'nullable|integer|min:0',
            'mon_tien_quyet_ids' => 'nullable|array',
            'mon_tien_quyet_ids.*' => 'exists:mon_hoc,id',
        ], [
            'ma_mon.required' => 'Mã môn học là bắt buộc',
            'ma_mon.unique' => 'Mã môn học đã tồn tại',
            'ten_mon.required' => 'Tên môn học là bắt buộc',
            'so_tin_chi.required' => 'Số tín chỉ là bắt buộc',
            'so_tin_chi.min' => 'Số tín chỉ phải lớn hơn 0',
            'so_tin_chi.max' => 'Số tín chỉ không được vượt quá 10',
            'loai_mon.required' => 'Loại môn học là bắt buộc',
            'hinh_thuc_day.required' => 'Hình thức dạy là bắt buộc',
        ]);

        DB::beginTransaction();
        try {
            // Tạo môn học
            $monHoc = MonHoc::create($validated);

            // Gán môn tiên quyết nếu có
            if (!empty($validated['mon_tien_quyet_ids'])) {
                $monHoc->monTienQuyets()->attach($validated['mon_tien_quyet_ids']);
            }

            DB::commit();

            return redirect()->route('dao-tao.mon-hoc.index')
                ->with('success', 'Thêm môn học thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $monHoc = MonHoc::with(['monTienQuyets', 'lopHocPhans.hocKy'])->findOrFail($id);
        return view('dao-tao.mon-hoc.show', compact('monHoc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $monHoc = MonHoc::with('monTienQuyets')->findOrFail($id);
        $allMonHocs = MonHoc::where('id', '!=', $id)->orderBy('ten_mon', 'asc')->get();

        return view('dao-tao.mon-hoc.edit', compact('monHoc', 'allMonHocs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $monHoc = MonHoc::findOrFail($id);
        $teachingModes = implode(',', array_keys(SystemConstants::TEACHING_MODES));

        $validated = $request->validate([
            'ma_mon' => [
                'required',
                'string',
                'max:50',
                Rule::unique('mon_hoc', 'ma_mon')->ignore($monHoc->id)
            ],
            'ten_mon' => 'required|string|max:255',
            'so_tin_chi' => 'required|integer|min:1|max:10',
            'mo_ta' => 'nullable|string|max:1000',
            'loai_mon' => 'required|string|max:100',
            'hinh_thuc_day' => 'required|in:' . $teachingModes,
            'thoi_luong' => 'nullable|integer|min:0',
            'so_buoi' => 'nullable|integer|min:0',
            'mon_tien_quyet_ids' => 'nullable|array',
            'mon_tien_quyet_ids.*' => 'exists:mon_hoc,id',
        ], [
            'ma_mon.required' => 'Mã môn học là bắt buộc',
            'ma_mon.unique' => 'Mã môn học đã tồn tại',
            'ten_mon.required' => 'Tên môn học là bắt buộc',
            'so_tin_chi.required' => 'Số tín chỉ là bắt buộc',
            'loai_mon.required' => 'Loại môn học là bắt buộc',
            'hinh_thuc_day.required' => 'Hình thức dạy là bắt buộc',
        ]);

        DB::beginTransaction();
        try {
            // Cập nhật thông tin môn học
            $monHoc->update($validated);

            // Sync môn tiên quyết
            if (isset($validated['mon_tien_quyet_ids'])) {
                $monHoc->monTienQuyets()->sync($validated['mon_tien_quyet_ids']);
            } else {
                $monHoc->monTienQuyets()->detach();
            }

            DB::commit();

            return redirect()->route('dao-tao.mon-hoc.index')
                ->with('success', 'Cập nhật môn học thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $monHoc = MonHoc::findOrFail($id);

        // Kiểm tra môn học có lớp học phần không
        if ($monHoc->lopHocPhans()->count() > 0) {
            return back()->with('error', 'Không thể xóa môn học đang có lớp học phần');
        }

        // Kiểm tra môn học có là môn tiên quyết của môn khác không
        if ($monHoc->monHocCanTienQuyet()->count() > 0) {
            return back()->with('error', 'Không thể xóa môn học đang là môn tiên quyết của môn khác');
        }

        DB::beginTransaction();
        try {
            // Xóa các môn tiên quyết
            $monHoc->monTienQuyets()->detach();

            // Xóa môn học
            $monHoc->delete();

            DB::commit();

            return redirect()->route('dao-tao.mon-hoc.index')
                ->with('success', 'Xóa môn học thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

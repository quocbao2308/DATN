<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\DaoTao\ChuongTrinhKhung;
use App\Models\DaoTao\ChuyenNganh;
use App\Models\DaoTao\MonHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ChuongTrinhKhungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ChuongTrinhKhung::with(['chuyenNganh.nganh', 'monHoc']);

        // Filter by chuyên ngành
        if ($request->filled('chuyen_nganh_id')) {
            $query->where('chuyen_nganh_id', $request->chuyen_nganh_id);
        }

        // Filter by loại môn học
        if ($request->filled('loai_mon_hoc')) {
            $query->where('loai_mon_hoc', $request->loai_mon_hoc);
        }

        // Filter by học kỳ gợi ý
        if ($request->filled('hoc_ky_goi_y')) {
            $query->where('hoc_ky_goi_y', $request->hoc_ky_goi_y);
        }

        $chuongTrinhKhungs = $query->paginate(15);
        $chuyenNganhs = ChuyenNganh::orderBy('ten_chuyen_nganh')->get();

        return view('dao-tao.chuong-trinh-khung.index', compact('chuongTrinhKhungs', 'chuyenNganhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chuyenNganhs = ChuyenNganh::orderBy('ten_chuyen_nganh')->get();
        $monHocs = MonHoc::orderBy('ten_mon')->get();

        return view('dao-tao.chuong-trinh-khung.create', compact('chuyenNganhs', 'monHocs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chuyen_nganh_id' => 'required|exists:chuyen_nganh,id',
            'mon_hoc_id' => [
                'required',
                'exists:mon_hoc,id',
                Rule::unique('chuong_trinh_khung')->where(function ($query) use ($request) {
                    return $query->where('chuyen_nganh_id', $request->chuyen_nganh_id);
                }),
            ],
            'hoc_ky_goi_y' => 'required|integer|min:1|max:8',
            'loai_mon_hoc' => 'required|string|max:255',
        ], [
            'chuyen_nganh_id.required' => 'Vui lòng chọn chuyên ngành',
            'mon_hoc_id.required' => 'Vui lòng chọn môn học',
            'mon_hoc_id.unique' => 'Môn học này đã có trong chương trình khung của chuyên ngành này',
            'hoc_ky_goi_y.required' => 'Vui lòng nhập học kỳ gợi ý',
            'hoc_ky_goi_y.min' => 'Học kỳ gợi ý phải từ 1 đến 8',
            'hoc_ky_goi_y.max' => 'Học kỳ gợi ý phải từ 1 đến 8',
            'loai_mon_hoc.required' => 'Vui lòng chọn loại môn học',
        ]);

        ChuongTrinhKhung::create($validated);

        return redirect()
            ->route('dao-tao.chuong-trinh-khung.index')
            ->with('success', 'Thêm chương trình khung thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChuongTrinhKhung $chuongTrinhKhung)
    {
        $chuongTrinhKhung->load(['chuyenNganh.nganh.khoa', 'monHoc']);

        return view('dao-tao.chuong-trinh-khung.show', compact('chuongTrinhKhung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChuongTrinhKhung $chuongTrinhKhung)
    {
        $chuyenNganhs = ChuyenNganh::orderBy('ten_chuyen_nganh')->get();
        $monHocs = MonHoc::orderBy('ten_mon')->get();

        return view('dao-tao.chuong-trinh-khung.edit', compact('chuongTrinhKhung', 'chuyenNganhs', 'monHocs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChuongTrinhKhung $chuongTrinhKhung)
    {
        $validated = $request->validate([
            'chuyen_nganh_id' => 'required|exists:chuyen_nganh,id',
            'mon_hoc_id' => [
                'required',
                'exists:mon_hoc,id',
                Rule::unique('chuong_trinh_khung')
                    ->where(function ($query) use ($request) {
                        return $query->where('chuyen_nganh_id', $request->chuyen_nganh_id);
                    })
                    ->ignore($chuongTrinhKhung->id),
            ],
            'hoc_ky_goi_y' => 'required|integer|min:1|max:8',
            'loai_mon_hoc' => 'required|string|max:255',
        ], [
            'chuyen_nganh_id.required' => 'Vui lòng chọn chuyên ngành',
            'mon_hoc_id.required' => 'Vui lòng chọn môn học',
            'mon_hoc_id.unique' => 'Môn học này đã có trong chương trình khung của chuyên ngành này',
            'hoc_ky_goi_y.required' => 'Vui lòng nhập học kỳ gợi ý',
            'hoc_ky_goi_y.min' => 'Học kỳ gợi ý phải từ 1 đến 8',
            'hoc_ky_goi_y.max' => 'Học kỳ gợi ý phải từ 1 đến 8',
            'loai_mon_hoc.required' => 'Vui lòng chọn loại môn học',
        ]);

        $chuongTrinhKhung->update($validated);

        return redirect()
            ->route('dao-tao.chuong-trinh-khung.index')
            ->with('success', 'Cập nhật chương trình khung thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChuongTrinhKhung $chuongTrinhKhung)
    {
        try {
            $chuongTrinhKhung->delete();

            return redirect()
                ->route('dao-tao.chuong-trinh-khung.index')
                ->with('success', 'Xóa chương trình khung thành công!');
        } catch (\Exception $e) {
            return redirect()
                ->route('dao-tao.chuong-trinh-khung.index')
                ->with('error', 'Không thể xóa chương trình khung này!');
        }
    }
}

<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\NhanSu\SinhVien;
use App\Models\DaoTao\Nganh;
use App\Models\DaoTao\ChuyenNganh;
use App\Models\HeThong\KhoaHoc;
use App\Models\HeThong\TrangThaiHocTap;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SinhVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SinhVien::with(['nganh.khoa', 'chuyenNganh', 'khoaHoc', 'trangThaiHocTap']);

        // Filter by khoa
        if ($request->filled('khoa_id')) {
            $query->whereHas('nganh', function($q) use ($request) {
                $q->where('khoa_id', $request->khoa_id);
            });
        }

        // Filter by nganh
        if ($request->filled('nganh_id')) {
            $query->where('nganh_id', $request->nganh_id);
        }

        // Filter by khoa hoc
        if ($request->filled('khoa_hoc_id')) {
            $query->where('khoa_hoc_id', $request->khoa_hoc_id);
        }

        // Filter by trang thai
        if ($request->filled('trang_thai_id')) {
            $query->where('trang_thai_hoc_tap_id', $request->trang_thai_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ma_sinh_vien', 'like', "%{$search}%")
                  ->orWhere('ho_ten', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sinhViens = $query->orderBy('ma_sinh_vien', 'desc')->paginate(15);

        // Data for filters
        $khoas = DB::table('khoa')->get();
        $nganhs = Nganh::all();
        $khoaHocs = KhoaHoc::orderBy('nam_bat_dau', 'desc')->get();
        $trangThais = TrangThaiHocTap::all();

        return view('dao-tao.sinh-vien.index', compact('sinhViens', 'khoas', 'nganhs', 'khoaHocs', 'trangThais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nganhs = Nganh::with('khoa')->get();
        $chuyenNganhs = ChuyenNganh::all();
        $khoaHocs = KhoaHoc::orderBy('nam_bat_dau', 'desc')->get();
        $trangThais = TrangThaiHocTap::all();

        return view('dao-tao.sinh-vien.create', compact('nganhs', 'chuyenNganhs', 'khoaHocs', 'trangThais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_sinh_vien' => 'required|string|max:50|unique:sinh_vien,ma_sinh_vien',
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:sinh_vien,email|unique:users,email',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'nullable|in:nam,nu,khac',
            'so_dien_thoai' => 'nullable|string|max:15',
            'so_nha_duong' => 'nullable|string|max:255',
            'phuong_xa' => 'nullable|string|max:100',
            'quan_huyen' => 'nullable|string|max:100',
            'tinh_thanh' => 'nullable|string|max:100',
            'can_cuoc_cong_dan' => 'nullable|string|max:20|unique:sinh_vien,can_cuoc_cong_dan',
            'ngay_cap_cccd' => 'nullable|date',
            'noi_cap_cccd' => 'nullable|string|max:255',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
            'nganh_id' => 'required|exists:nganh,id',
            'chuyen_nganh_id' => 'nullable|exists:chuyen_nganh,id',
            'ky_hien_tai' => 'nullable|integer|min:1|max:10',
            'trang_thai_hoc_tap_id' => 'required|exists:trang_thai_hoc_tap,id',
        ], [
            'ma_sinh_vien.required' => 'Mã sinh viên là bắt buộc',
            'ma_sinh_vien.unique' => 'Mã sinh viên đã tồn tại',
            'ho_ten.required' => 'Họ tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.unique' => 'Email đã được sử dụng',
            'khoa_hoc_id.required' => 'Khóa học là bắt buộc',
            'nganh_id.required' => 'Ngành là bắt buộc',
            'trang_thai_hoc_tap_id.required' => 'Trạng thái học tập là bắt buộc',
        ]);

        DB::beginTransaction();
        try {
            // 1. Tạo tài khoản user
            $user = User::create([
                'name' => $validated['ho_ten'],
                'email' => $validated['email'],
                'password' => Hash::make('12345678'), // Password mặc định
            ]);

            // 2. Gán vai trò Sinh viên (ID: 6)
            DB::table('tai_khoan_vai_tro')->insert([
                'tai_khoan_id' => $user->id,
                'vai_tro_id' => 6, // Sinh viên
            ]);

            // 3. Upload ảnh đại diện
            if ($request->hasFile('anh_dai_dien')) {
                $validated['anh_dai_dien'] = $request->file('anh_dai_dien')->store('sinh-vien', 'public');
            }

            // 4. Tạo hồ sơ sinh viên
            $validated['user_id'] = $user->id;
            SinhVien::create($validated);

            DB::commit();

            return redirect()->route('dao-tao.sinh-vien.index')
                ->with('success', 'Thêm sinh viên thành công. Password mặc định: 12345678');
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
        $sinhVien = SinhVien::with(['nganh.khoa', 'chuyenNganh', 'khoaHoc', 'trangThaiHocTap', 'user'])->findOrFail($id);
        return view('dao-tao.sinh-vien.show', compact('sinhVien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sinhVien = SinhVien::findOrFail($id);
        $nganhs = Nganh::with('khoa')->get();
        $chuyenNganhs = ChuyenNganh::all();
        $khoaHocs = KhoaHoc::orderBy('nam_bat_dau', 'desc')->get();
        $trangThais = TrangThaiHocTap::all();

        return view('dao-tao.sinh-vien.edit', compact('sinhVien', 'nganhs', 'chuyenNganhs', 'khoaHocs', 'trangThais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sinhVien = SinhVien::findOrFail($id);

        $validated = $request->validate([
            'ma_sinh_vien' => ['required', 'string', 'max:50', Rule::unique('sinh_vien')->ignore($sinhVien->id)],
            'ho_ten' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('sinh_vien')->ignore($sinhVien->id)],
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'nullable|in:nam,nu,khac',
            'so_dien_thoai' => 'nullable|string|max:15',
            'so_nha_duong' => 'nullable|string|max:255',
            'phuong_xa' => 'nullable|string|max:100',
            'quan_huyen' => 'nullable|string|max:100',
            'tinh_thanh' => 'nullable|string|max:100',
            'can_cuoc_cong_dan' => ['nullable', 'string', 'max:20', Rule::unique('sinh_vien')->ignore($sinhVien->id)],
            'ngay_cap_cccd' => 'nullable|date',
            'noi_cap_cccd' => 'nullable|string|max:255',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'khoa_hoc_id' => 'required|exists:khoa_hoc,id',
            'nganh_id' => 'required|exists:nganh,id',
            'chuyen_nganh_id' => 'nullable|exists:chuyen_nganh,id',
            'ky_hien_tai' => 'nullable|integer|min:1|max:10',
            'trang_thai_hoc_tap_id' => 'required|exists:trang_thai_hoc_tap,id',
        ]);

        DB::beginTransaction();
        try {
            // Upload ảnh mới nếu có
            if ($request->hasFile('anh_dai_dien')) {
                // Xóa ảnh cũ
                if ($sinhVien->anh_dai_dien) {
                    Storage::disk('public')->delete($sinhVien->anh_dai_dien);
                }
                $validated['anh_dai_dien'] = $request->file('anh_dai_dien')->store('sinh-vien', 'public');
            }

            // Cập nhật thông tin
            $sinhVien->update($validated);

            // Cập nhật user email nếu thay đổi
            if ($sinhVien->user && $sinhVien->user->email !== $validated['email']) {
                $sinhVien->user->update(['email' => $validated['email']]);
            }

            DB::commit();

            return redirect()->route('dao-tao.sinh-vien.index')
                ->with('success', 'Cập nhật sinh viên thành công');
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
        $sinhVien = SinhVien::findOrFail($id);

        // Kiểm tra sinh viên có đăng ký môn học chưa
        if ($sinhVien->dangKyMonHocs()->count() > 0) {
            return back()->with('error', 'Không thể xóa sinh viên đã đăng ký môn học');
        }

        // Kiểm tra sinh viên có điểm chưa
        if ($sinhVien->bangDiems()->count() > 0) {
            return back()->with('error', 'Không thể xóa sinh viên đã có điểm');
        }

        DB::beginTransaction();
        try {
            // Xóa ảnh đại diện
            if ($sinhVien->anh_dai_dien) {
                Storage::disk('public')->delete($sinhVien->anh_dai_dien);
            }

            // Xóa user (nếu có)
            if ($sinhVien->user) {
                $sinhVien->user->delete();
            }

            // Xóa sinh viên
            $sinhVien->delete();

            DB::commit();

            return redirect()->route('dao-tao.sinh-vien.index')
                ->with('success', 'Xóa sinh viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

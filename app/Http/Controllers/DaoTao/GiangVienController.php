<?php

namespace App\Http\Controllers\DaoTao;

use App\Http\Controllers\Controller;
use App\Models\NhanSu\GiangVien;
use App\Models\DaoTao\Khoa;
use App\Models\HeThong\DmTrinhDo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GiangVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GiangVien::with(['khoa', 'trinhDo']);

        // Filter by khoa
        if ($request->filled('khoa_id')) {
            $query->where('khoa_id', $request->khoa_id);
        }

        // Filter by trinh do
        if ($request->filled('trinh_do_id')) {
            $query->where('trinh_do_id', $request->trinh_do_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ma_giang_vien', 'like', "%{$search}%")
                  ->orWhere('ho_ten', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $giangViens = $query->orderBy('ma_giang_vien', 'desc')->paginate(15);

        // Data for filters
        $khoas = Khoa::all();
        $trinhDos = DmTrinhDo::all();

        return view('dao-tao.giang-vien.index', compact('giangViens', 'khoas', 'trinhDos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $khoas = Khoa::all();
        $trinhDos = DmTrinhDo::all();

        return view('dao-tao.giang-vien.create', compact('khoas', 'trinhDos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_giang_vien' => 'required|string|max:50|unique:giang_vien,ma_giang_vien',
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:giang_vien,email|unique:users,email',
            'so_dien_thoai' => 'nullable|string|max:15',
            'khoa_id' => 'required|exists:khoa,id',
            'trinh_do_id' => 'required|exists:dm_trinh_do,id',
            'chuyen_mon' => 'nullable|string|max:255',
            'ngay_vao_truong' => 'nullable|date',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'ma_giang_vien.required' => 'Mã giảng viên là bắt buộc',
            'ma_giang_vien.unique' => 'Mã giảng viên đã tồn tại',
            'ho_ten.required' => 'Họ tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.unique' => 'Email đã được sử dụng',
            'khoa_id.required' => 'Khoa là bắt buộc',
            'trinh_do_id.required' => 'Trình độ là bắt buộc',
        ]);

        DB::beginTransaction();
        try {
            // 1. Tạo tài khoản user
            $user = User::create([
                'name' => $validated['ho_ten'],
                'email' => $validated['email'],
                'password' => Hash::make('12345678'), // Password mặc định
            ]);

            // 2. Gán vai trò Giảng viên (ID: 5)
            DB::table('tai_khoan_vai_tro')->insert([
                'tai_khoan_id' => $user->id,
                'vai_tro_id' => 5, // Giảng viên
            ]);

            // 3. Upload ảnh đại diện
            if ($request->hasFile('anh_dai_dien')) {
                $validated['anh_dai_dien'] = $request->file('anh_dai_dien')->store('giang-vien', 'public');
            }

            // 4. Tạo hồ sơ giảng viên
            $validated['user_id'] = $user->id;
            GiangVien::create($validated);

            DB::commit();

            return redirect()->route('dao-tao.giang-vien.index')
                ->with('success', 'Thêm giảng viên thành công. Password mặc định: 12345678');
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
        $giangVien = GiangVien::with(['khoa', 'trinhDo', 'user'])->findOrFail($id);
        return view('dao-tao.giang-vien.show', compact('giangVien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $giangVien = GiangVien::findOrFail($id);
        $khoas = Khoa::all();
        $trinhDos = DmTrinhDo::all();

        return view('dao-tao.giang-vien.edit', compact('giangVien', 'khoas', 'trinhDos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $giangVien = GiangVien::findOrFail($id);

        $validated = $request->validate([
            'ma_giang_vien' => ['required', 'string', 'max:50', Rule::unique('giang_vien')->ignore($giangVien->id)],
            'ho_ten' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('giang_vien')->ignore($giangVien->id)],
            'so_dien_thoai' => 'nullable|string|max:15',
            'khoa_id' => 'required|exists:khoa,id',
            'trinh_do_id' => 'required|exists:dm_trinh_do,id',
            'chuyen_mon' => 'nullable|string|max:255',
            'ngay_vao_truong' => 'nullable|date',
            'anh_dai_dien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Upload ảnh mới nếu có
            if ($request->hasFile('anh_dai_dien')) {
                // Xóa ảnh cũ
                if ($giangVien->anh_dai_dien) {
                    Storage::disk('public')->delete($giangVien->anh_dai_dien);
                }
                $validated['anh_dai_dien'] = $request->file('anh_dai_dien')->store('giang-vien', 'public');
            }

            // Cập nhật thông tin
            $giangVien->update($validated);

            // Cập nhật user email nếu thay đổi
            if ($giangVien->user && $giangVien->user->email !== $validated['email']) {
                $giangVien->user->update(['email' => $validated['email']]);
            }

            DB::commit();

            return redirect()->route('dao-tao.giang-vien.index')
                ->with('success', 'Cập nhật giảng viên thành công');
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
        $giangVien = GiangVien::findOrFail($id);

        // Kiểm tra giảng viên có lớp học phần chưa
        if ($giangVien->lopHocPhans()->count() > 0) {
            return back()->with('error', 'Không thể xóa giảng viên đang dạy lớp học phần');
        }

        DB::beginTransaction();
        try {
            // Xóa ảnh đại diện
            if ($giangVien->anh_dai_dien) {
                Storage::disk('public')->delete($giangVien->anh_dai_dien);
            }

            // Xóa user (nếu có)
            if ($giangVien->user) {
                $giangVien->user->delete();
            }

            // Xóa giảng viên
            $giangVien->delete();

            DB::commit();

            return redirect()->route('dao-tao.giang-vien.index')
                ->with('success', 'Xóa giảng viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

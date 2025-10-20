<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = $request->get('role', 'all');
        $search = $request->get('search');
        $khoa_id = $request->get('khoa_id');
        $nganh_id = $request->get('nganh_id');
        $trang_thai_id = $request->get('trang_thai_id');

        // Lấy danh sách theo vai trò
        if ($role === 'admin') {
            $query = DB::table('admin')
                ->join('users', 'admin.user_id', '=', 'users.id')
                ->select('admin.*', 'users.email', 'users.name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('admin.ho_ten', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('admin.so_dien_thoai', 'like', "%{$search}%");
                });
            }

            $items = $query->orderBy('admin.id', 'desc')->paginate(15);
        } elseif ($role === 'dao_tao') {
            $query = DB::table('dao_tao')
                ->join('users', 'dao_tao.user_id', '=', 'users.id')
                ->select('dao_tao.*', 'users.email', 'users.name');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('dao_tao.ho_ten', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('dao_tao.so_dien_thoai', 'like', "%{$search}%");
                });
            }

            $items = $query->orderBy('dao_tao.id', 'desc')->paginate(15);
        } elseif ($role === 'giang_vien') {
            $query = DB::table('giang_vien')
                ->join('users', 'giang_vien.user_id', '=', 'users.id')
                ->join('khoa', 'giang_vien.khoa_id', '=', 'khoa.id')
                ->join('dm_trinh_do', 'giang_vien.trinh_do_id', '=', 'dm_trinh_do.id')
                ->select('giang_vien.*', 'users.email', 'users.name', 'khoa.ten_khoa', 'dm_trinh_do.ten_trinh_do');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('giang_vien.ho_ten', 'like', "%{$search}%")
                        ->orWhere('giang_vien.ma_giang_vien', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('giang_vien.so_dien_thoai', 'like', "%{$search}%");
                });
            }

            if ($khoa_id) {
                $query->where('giang_vien.khoa_id', $khoa_id);
            }

            $items = $query->orderBy('giang_vien.id', 'desc')->paginate(15);
        } elseif ($role === 'sinh_vien') {
            $query = DB::table('sinh_vien')
                ->join('users', 'sinh_vien.user_id', '=', 'users.id')
                ->join('nganh', 'sinh_vien.nganh_id', '=', 'nganh.id')
                ->join('chuyen_nganh', 'sinh_vien.chuyen_nganh_id', '=', 'chuyen_nganh.id')
                ->join('khoa_hoc', 'sinh_vien.khoa_hoc_id', '=', 'khoa_hoc.id')
                ->join('trang_thai_hoc_tap', 'sinh_vien.trang_thai_hoc_tap_id', '=', 'trang_thai_hoc_tap.id')
                ->select('sinh_vien.*', 'users.email', 'users.name', 'nganh.ten_nganh', 'chuyen_nganh.ten_chuyen_nganh', 'khoa_hoc.ten_khoa_hoc', 'trang_thai_hoc_tap.ten_trang_thai');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('sinh_vien.ho_ten', 'like', "%{$search}%")
                        ->orWhere('sinh_vien.ma_sinh_vien', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('sinh_vien.so_dien_thoai', 'like', "%{$search}%");
                });
            }

            if ($nganh_id) {
                $query->where('sinh_vien.nganh_id', $nganh_id);
            }

            if ($trang_thai_id) {
                $query->where('sinh_vien.trang_thai_hoc_tap_id', $trang_thai_id);
            }

            $items = $query->orderBy('sinh_vien.id', 'desc')->paginate(15);
        } else {
            // Hiển thị tổng hợp
            $query = User::with(['admin', 'daoTao', 'giangVien', 'sinhVien']);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $items = $query->latest()->paginate(15);

            foreach ($items as $user) {
                $user->role = $this->getUserRole($user->email);
            }
        }

        // Lấy data cho filter dropdowns
        $khoas = DB::table('khoa')->orderBy('ten_khoa')->get();
        $nganhs = DB::table('nganh')->orderBy('ten_nganh')->get();
        $trangThais = DB::table('trang_thai_hoc_tap')->orderBy('id')->get();

        return view('admin.users.index', compact('items', 'role', 'khoas', 'nganhs', 'trangThais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $role = $request->get('role', 'admin');

        // Lấy dữ liệu cho dropdown - select rõ ràng các columns
        $khoas = DB::table('khoa')->select('id', 'ten_khoa')->orderBy('ten_khoa')->get();
        $nganhs = DB::table('nganh')->select('id', 'ten_nganh', 'khoa_id')->orderBy('ten_nganh')->get();
        $chuyenNganhs = DB::table('chuyen_nganh')->select('id', 'ten_chuyen_nganh', 'nganh_id')->orderBy('ten_chuyen_nganh')->get();
        $trinhDos = DB::table('dm_trinh_do')->orderBy('id')->get();
        $khoaHocs = DB::table('khoa_hoc')->orderBy('nam_bat_dau', 'desc')->get();
        $trangThais = DB::table('trang_thai_hoc_tap')->orderBy('id')->get();

        return view('admin.users.create', compact('role', 'khoas', 'nganhs', 'chuyenNganhs', 'trinhDos', 'khoaHocs', 'trangThais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation cơ bản
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,dao_tao,giang_vien,sinh_vien',
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
        ];

        // Validation riêng cho từng vai trò
        if ($request->role === 'admin') {
            $rules['anh_dai_dien'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if ($request->role === 'dao_tao') {
            $rules['anh_dai_dien'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if ($request->role === 'giang_vien') {
            $rules['khoa_id'] = 'required|exists:khoa,id';
            $rules['trinh_do_id'] = 'required|exists:dm_trinh_do,id';
            $rules['ma_giang_vien'] = 'required|unique:giang_vien,ma_giang_vien';
            $rules['chuyen_mon'] = 'nullable|string|max:255';
            $rules['ngay_vao_truong'] = 'nullable|date|before_or_equal:today';
            $rules['anh_dai_dien'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if ($request->role === 'sinh_vien') {
            $rules['ma_sinh_vien'] = 'required|unique:sinh_vien,ma_sinh_vien';
            $rules['nganh_id'] = 'required|exists:nganh,id';
            $rules['chuyen_nganh_id'] = 'required|exists:chuyen_nganh,id';
            $rules['khoa_hoc_id'] = 'required|exists:khoa_hoc,id';
            $rules['trang_thai_hoc_tap_id'] = 'required|exists:trang_thai_hoc_tap,id';
            $rules['ngay_sinh'] = 'nullable|date|before:today';
            $rules['gioi_tinh'] = 'nullable|in:nam,nu,khac';
            $rules['ky_hien_tai'] = 'nullable|integer|min:1|max:10';
            // Địa chỉ
            $rules['so_nha_duong'] = 'nullable|string|max:255';
            $rules['phuong_xa'] = 'nullable|string|max:255';
            $rules['quan_huyen'] = 'nullable|string|max:255';
            $rules['tinh_thanh'] = 'nullable|string|max:255';
            // CCCD
            $rules['can_cuoc_cong_dan'] = 'nullable|string|size:12|unique:sinh_vien,can_cuoc_cong_dan';
            $rules['ngay_cap_cccd'] = 'nullable|date|before:today';
            $rules['noi_cap_cccd'] = 'nullable|string|max:255';
            // Ảnh đại diện
            $rules['anh_dai_dien'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // 1. Tạo user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(),
            ]);

            // 2. Tạo bản ghi vai trò tương ứng (truyền cả $request để có file upload)
            $this->assignRole($user, $validated['role'], $request->all());

            // 3. Gán vai trò phân quyền mặc định
            $this->assignDefaultPermissionRole($user->id, $validated['role']);

            DB::commit();
            return redirect()->route('admin.users.index', ['role' => $validated['role']])
                ->with('success', 'Tạo tài khoản thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $role = $this->getUserRole($user->email);

        // Load thông tin chi tiết dựa vào vai trò
        $details = null;
        if ($role === 'Admin') {
            // Tìm theo cả user_id và email để đảm bảo tìm được
            $details = DB::table('admin')
                ->select('admin.*')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhere('email', $user->email);
                })
                ->first();
        } elseif ($role === 'Đào tạo') {
            $details = DB::table('dao_tao')
                ->select('dao_tao.*')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhere('email', $user->email);
                })
                ->first();
        } elseif ($role === 'Giảng viên') {
            $details = DB::table('giang_vien')
                ->join('khoa', 'giang_vien.khoa_id', '=', 'khoa.id')
                ->join('dm_trinh_do', 'giang_vien.trinh_do_id', '=', 'dm_trinh_do.id')
                ->select('giang_vien.*', 'khoa.ten_khoa', 'dm_trinh_do.ten_trinh_do')
                ->where(function ($q) use ($user) {
                    $q->where('giang_vien.user_id', $user->id)
                        ->orWhere('giang_vien.email', $user->email);
                })
                ->first();
        } elseif ($role === 'Sinh viên') {
            $details = DB::table('sinh_vien')
                ->join('nganh', 'sinh_vien.nganh_id', '=', 'nganh.id')
                ->join('chuyen_nganh', 'sinh_vien.chuyen_nganh_id', '=', 'chuyen_nganh.id')
                ->join('khoa_hoc', 'sinh_vien.khoa_hoc_id', '=', 'khoa_hoc.id')
                ->join('trang_thai_hoc_tap', 'sinh_vien.trang_thai_hoc_tap_id', '=', 'trang_thai_hoc_tap.id')
                ->select('sinh_vien.*', 'nganh.ten_nganh', 'chuyen_nganh.ten_chuyen_nganh', 'khoa_hoc.ten_khoa_hoc', 'trang_thai_hoc_tap.ten_trang_thai')
                ->where(function ($q) use ($user) {
                    $q->where('sinh_vien.user_id', $user->id)
                        ->orWhere('sinh_vien.email', $user->email);
                })
                ->first();
        }

        return view('admin.users.show', compact('user', 'role', 'details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $currentRole = $this->getUserRole($user->email);

        // Load thông tin chi tiết theo vai trò hiện tại
        $roleData = null;
        $roleKey = strtolower(str_replace(['Đào tạo', 'Giảng viên', 'Sinh viên', 'Admin'], ['dao_tao', 'giang_vien', 'sinh_vien', 'admin'], $currentRole));

        if ($roleKey === 'admin') {
            $roleData = DB::table('admin')->where('user_id', $user->id)->first();
        } elseif ($roleKey === 'dao_tao') {
            $roleData = DB::table('dao_tao')->where('user_id', $user->id)->first();
        } elseif ($roleKey === 'giang_vien') {
            $roleData = DB::table('giang_vien')->where('user_id', $user->id)->first();
        } elseif ($roleKey === 'sinh_vien') {
            $roleData = DB::table('sinh_vien')->where('user_id', $user->id)->first();
        }

        // Lấy thông tin vai trò và quyền hiện tại
        $userRole = DB::table('tai_khoan_vai_tro')
            ->join('vai_tro', 'tai_khoan_vai_tro.vai_tro_id', '=', 'vai_tro.id')
            ->where('tai_khoan_vai_tro.tai_khoan_id', $user->id)
            ->select('vai_tro.id', 'vai_tro.ten_vai_tro')
            ->first();

        // Lấy danh sách tất cả vai trò
        $allVaiTros = DB::table('vai_tro')->orderBy('id')->get();

        // Lấy dữ liệu cho dropdown
        $khoas = DB::table('khoa')->select('id', 'ten_khoa')->orderBy('ten_khoa')->get();
        $nganhs = DB::table('nganh')->select('id', 'ten_nganh', 'khoa_id')->orderBy('ten_nganh')->get();
        $chuyenNganhs = DB::table('chuyen_nganh')->select('id', 'ten_chuyen_nganh', 'nganh_id')->orderBy('ten_chuyen_nganh')->get();
        $trinhDos = DB::table('dm_trinh_do')->orderBy('id')->get();
        $khoaHocs = DB::table('khoa_hoc')->orderBy('nam_bat_dau', 'desc')->get();
        $trangThais = DB::table('trang_thai_hoc_tap')->orderBy('id')->get();

        return view('admin.users.edit', compact(
            'user',
            'currentRole',
            'roleKey',
            'roleData',
            'userRole',
            'allVaiTros',
            'khoas',
            'nganhs',
            'chuyenNganhs',
            'trinhDos',
            'khoaHocs',
            'trangThais'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Lấy vai trò hiện tại trước khi validate
        $currentRoleLabel = $this->getUserRole($user->email);
        $currentRoleKey = strtolower(str_replace(['Đào tạo', 'Giảng viên', 'Sinh viên', 'Admin'], ['dao_tao', 'giang_vien', 'sinh_vien', 'admin'], $currentRoleLabel));

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,dao_tao,giang_vien,sinh_vien',
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
        ];

        // Validation cho vai trò mới
        if ($request->role === 'giang_vien') {
            $rules['khoa_id'] = 'required|exists:khoa,id';
            $rules['trinh_do_id'] = 'required|exists:dm_trinh_do,id';
            $rules['ma_giang_vien'] = 'required|unique:giang_vien,ma_giang_vien' . ($currentRoleKey === 'giang_vien' ? ',' . DB::table('giang_vien')->where('user_id', $user->id)->value('id') : '');
            $rules['chuyen_mon'] = 'nullable|string|max:255';
            $rules['ngay_vao_truong'] = 'nullable|date|before_or_equal:today';
        }

        if ($request->role === 'sinh_vien') {
            $rules['ma_sinh_vien'] = 'required|unique:sinh_vien,ma_sinh_vien' . ($currentRoleKey === 'sinh_vien' ? ',' . DB::table('sinh_vien')->where('user_id', $user->id)->value('id') : '');
            $rules['nganh_id'] = 'required|exists:nganh,id';
            $rules['chuyen_nganh_id'] = 'required|exists:chuyen_nganh,id';
            $rules['khoa_hoc_id'] = 'required|exists:khoa_hoc,id';
            $rules['trang_thai_hoc_tap_id'] = 'required|exists:trang_thai_hoc_tap,id';
            $rules['ngay_sinh'] = 'nullable|date|before:today';
            $rules['gioi_tinh'] = 'nullable|in:Nam,Nữ,Khác';
            // Địa chỉ
            $rules['so_nha_duong'] = 'nullable|string|max:255';
            $rules['phuong_xa'] = 'nullable|string|max:255';
            $rules['quan_huyen'] = 'nullable|string|max:255';
            $rules['tinh_thanh'] = 'nullable|string|max:255';
            // CCCD
            $rules['can_cuoc_cong_dan'] = 'nullable|string|size:12|unique:sinh_vien,can_cuoc_cong_dan' . ($currentRoleKey === 'sinh_vien' ? ',' . DB::table('sinh_vien')->where('user_id', $user->id)->value('id') : '');
            $rules['ngay_cap_cccd'] = 'nullable|date|before:today';
            $rules['noi_cap_cccd'] = 'nullable|string|max:255';
            // Ảnh đại diện - CHỈ admin mới được upload cho sinh viên
            $rules['anh_dai_dien'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // Cập nhật thông tin user
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);

            // Nếu đổi vai trò → xóa vai trò cũ và tạo vai trò mới
            if ($currentRoleKey !== $validated['role']) {
                $this->removeRole($user);
                $this->assignRole($user, $validated['role'], $request);
                $message = 'Đổi vai trò và cập nhật thông tin thành công!';
            } else {
                // Cùng vai trò → chỉ cập nhật thông tin
                $this->updateRoleData($user, $validated['role'], $request);
                $message = 'Cập nhật thông tin thành công!';
            }

            // Cập nhật vai trò phân quyền nếu có
            if ($request->has('vai_tro_id')) {
                $this->updateUserPermissionRole($user->id, $request->vai_tro_id);
            }

            DB::commit();
            return redirect()->route('admin.users.index', ['role' => $validated['role']])
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Có lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            // Xóa bản ghi vai trò trước
            $this->removeRole($user);

            // Xóa user
            $user->delete();

            DB::commit();
            return redirect()->route('admin.users.index')
                ->with('success', 'Xóa tài khoản thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Reset mật khẩu cho user
     * 
     * Admin có thể reset mật khẩu cho bất kỳ user nào
     * Mật khẩu mới sẽ được tạo ngẫu nhiên và gửi qua email
     */
    public function resetPassword(User $user)
    {
        try {
            // Tạo mật khẩu ngẫu nhiên (8 ký tự)
            $newPassword = \Illuminate\Support\Str::random(8);

            // Cập nhật mật khẩu
            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            // Xóa cache quyền
            \App\Helpers\PermissionHelper::clearUserPermissionsCache($user->id);

            // Lấy tên hiển thị của user
            $userName = $user->name;

            // Gửi email thông báo mật khẩu mới cho user
            try {
                Mail::to($user->email)->send(new PasswordResetMail($userName, $user->email, $newPassword));

                return back()->with('success', "✅ Đã reset mật khẩu thành công!<br><br>📧 <strong>Email đã được gửi đến:</strong> {$user->email}<br>🔑 <strong>Mật khẩu mới:</strong> <code style='font-size: 16px; background: #f8f9fa; padding: 5px 10px; border-radius: 4px;'>$newPassword</code><br><br><small class='text-muted'>User sẽ nhận được email hướng dẫn đăng nhập với mật khẩu mới.</small>");
            } catch (\Exception $mailError) {
                // Nếu gửi email thất bại, vẫn hiển thị password cho admin
                Log::error('Failed to send password reset email: ' . $mailError->getMessage());

                return back()->with('warning', "⚠️ Reset mật khẩu thành công nhưng không thể gửi email!<br><br>🔑 <strong>Mật khẩu mới:</strong> <code style='font-size: 16px; background: #fff3cd; padding: 5px 10px; border-radius: 4px;'>$newPassword</code><br><br><small class='text-danger'>Lỗi email: {$mailError->getMessage()}</small><br><small class='text-muted'>Vui lòng thông báo mật khẩu này cho người dùng qua các kênh khác.</small>");
            }
        } catch (\Exception $e) {
            return back()->with('error', '❌ Có lỗi khi reset mật khẩu: ' . $e->getMessage());
        }
    }

    /**
     * Xác định vai trò của user
     */
    private function getUserRole($email)
    {
        if (DB::table('admin')->where('email', $email)->exists()) {
            return 'Admin';
        }
        if (DB::table('dao_tao')->where('email', $email)->exists()) {
            return 'Đào tạo';
        }
        if (DB::table('giang_vien')->where('email', $email)->exists()) {
            return 'Giảng viên';
        }
        if (DB::table('sinh_vien')->where('email', $email)->exists()) {
            return 'Sinh viên';
        }
        return 'Chưa phân quyền';
    }

    /**
     * Gán vai trò cho user
     */
    private function assignRole($user, $role, $data)
    {
        $baseData = [
            'ho_ten' => $data['ho_ten'],
            'email' => $user->email,
            'so_dien_thoai' => $data['so_dien_thoai'] ?? null,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        switch ($role) {
            case 'admin':
                // Upload ảnh đại diện nếu có
                $anhDaiDien = null;
                if (isset($data['anh_dai_dien']) && $data['anh_dai_dien']->isValid()) {
                    $anhDaiDien = $data['anh_dai_dien']->store('admin/avatar', 'public');
                }

                DB::table('admin')->insert(array_merge($baseData, [
                    'anh_dai_dien' => $anhDaiDien,
                ]));
                break;

            case 'dao_tao':
                // Upload ảnh đại diện nếu có
                $anhDaiDien = null;
                if (isset($data['anh_dai_dien']) && $data['anh_dai_dien']->isValid()) {
                    $anhDaiDien = $data['anh_dai_dien']->store('dao_tao/avatar', 'public');
                }

                DB::table('dao_tao')->insert(array_merge($baseData, [
                    'anh_dai_dien' => $anhDaiDien,
                ]));
                break;

            case 'giang_vien':
                // Upload ảnh đại diện nếu có
                $anhDaiDien = null;
                if (isset($data['anh_dai_dien']) && $data['anh_dai_dien']->isValid()) {
                    $anhDaiDien = $data['anh_dai_dien']->store('giang_vien/avatar', 'public');
                }

                DB::table('giang_vien')->insert(array_merge($baseData, [
                    'ma_giang_vien' => $data['ma_giang_vien'],
                    'khoa_id' => $data['khoa_id'],
                    'trinh_do_id' => $data['trinh_do_id'],
                    'chuyen_mon' => $data['chuyen_mon'] ?? null,
                    'ngay_vao_truong' => $data['ngay_vao_truong'] ?? null,
                    'anh_dai_dien' => $anhDaiDien,
                ]));
                break;

            case 'sinh_vien':
                // Upload ảnh đại diện nếu có
                $anhDaiDien = null;
                if (isset($data['anh_dai_dien']) && $data['anh_dai_dien']->isValid()) {
                    $anhDaiDien = $data['anh_dai_dien']->store('sinh_vien/avatar', 'public');
                }

                DB::table('sinh_vien')->insert(array_merge($baseData, [
                    'ma_sinh_vien' => $data['ma_sinh_vien'],
                    'nganh_id' => $data['nganh_id'],
                    'chuyen_nganh_id' => $data['chuyen_nganh_id'],
                    'khoa_hoc_id' => $data['khoa_hoc_id'],
                    'trang_thai_hoc_tap_id' => $data['trang_thai_hoc_tap_id'],
                    'ngay_sinh' => $data['ngay_sinh'] ?? null,
                    'gioi_tinh' => $data['gioi_tinh'] ?? null,
                    'ky_hien_tai' => $data['ky_hien_tai'] ?? 1,
                    // Địa chỉ
                    'so_nha_duong' => $data['so_nha_duong'] ?? null,
                    'phuong_xa' => $data['phuong_xa'] ?? null,
                    'quan_huyen' => $data['quan_huyen'] ?? null,
                    'tinh_thanh' => $data['tinh_thanh'] ?? null,
                    // CCCD
                    'can_cuoc_cong_dan' => $data['can_cuoc_cong_dan'] ?? null,
                    'ngay_cap_cccd' => $data['ngay_cap_cccd'] ?? null,
                    'noi_cap_cccd' => $data['noi_cap_cccd'] ?? null,
                    // Ảnh đại diện
                    'anh_dai_dien' => $anhDaiDien,
                ]));
                break;
        }
    }

    /**
     * Xóa vai trò của user
     */
    private function removeRole($user)
    {
        DB::table('admin')->where('email', $user->email)->delete();
        DB::table('dao_tao')->where('email', $user->email)->delete();
        DB::table('giang_vien')->where('email', $user->email)->delete();
        DB::table('sinh_vien')->where('email', $user->email)->delete();
    }

    /**
     * Cập nhật thông tin vai trò (không đổi vai trò)
     */
    private function updateRoleData($user, $role, $request)
    {
        $baseData = [
            'ho_ten' => $request->ho_ten,
            'email' => $user->email,
            'so_dien_thoai' => $request->so_dien_thoai ?? null,
            'updated_at' => now(),
        ];

        switch ($role) {
            case 'admin':
                DB::table('admin')->where('user_id', $user->id)->update($baseData);
                break;

            case 'dao_tao':
                DB::table('dao_tao')->where('user_id', $user->id)->update($baseData);
                break;

            case 'giang_vien':
                $updateData = array_merge($baseData, [
                    'ma_giang_vien' => $request->ma_giang_vien,
                    'khoa_id' => $request->khoa_id,
                    'trinh_do_id' => $request->trinh_do_id,
                    'chuyen_mon' => $request->chuyen_mon ?? null,
                    'ngay_vao_truong' => $request->ngay_vao_truong ?? null,
                ]);

                DB::table('giang_vien')->where('user_id', $user->id)->update($updateData);
                break;

            case 'sinh_vien':
                $updateData = array_merge($baseData, [
                    'ma_sinh_vien' => $request->ma_sinh_vien,
                    'nganh_id' => $request->nganh_id,
                    'chuyen_nganh_id' => $request->chuyen_nganh_id,
                    'khoa_hoc_id' => $request->khoa_hoc_id,
                    'trang_thai_hoc_tap_id' => $request->trang_thai_hoc_tap_id,
                    'ngay_sinh' => $request->ngay_sinh ?? null,
                    'gioi_tinh' => $request->gioi_tinh ?? null,
                    'ky_hien_tai' => $request->ky_hien_tai ?? 1,
                    // Địa chỉ
                    'so_nha_duong' => $request->so_nha_duong ?? null,
                    'phuong_xa' => $request->phuong_xa ?? null,
                    'quan_huyen' => $request->quan_huyen ?? null,
                    'tinh_thanh' => $request->tinh_thanh ?? null,
                    // CCCD
                    'can_cuoc_cong_dan' => $request->can_cuoc_cong_dan ?? null,
                    'ngay_cap_cccd' => $request->ngay_cap_cccd ?? null,
                    'noi_cap_cccd' => $request->noi_cap_cccd ?? null,
                ]);

                // Xử lý upload ảnh đại diện cho sinh viên (CHỈ admin mới upload được)
                if ($request->hasFile('anh_dai_dien') && $request->file('anh_dai_dien')->isValid()) {
                    // Xóa ảnh cũ nếu có
                    $oldRecord = DB::table('sinh_vien')->where('user_id', $user->id)->first();
                    if ($oldRecord && $oldRecord->anh_dai_dien) {
                        Storage::disk('public')->delete($oldRecord->anh_dai_dien);
                    }

                    // Upload ảnh mới
                    $file = $request->file('anh_dai_dien');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('sinh-vien/avatars', $filename, 'public');
                    $updateData['anh_dai_dien'] = $path;
                }

                DB::table('sinh_vien')->where('user_id', $user->id)->update($updateData);
                break;
        }
    }

    /**
     * Cập nhật vai trò phân quyền của user
     */
    private function updateUserPermissionRole($userId, $vaiTroId): void
    {
        // Xóa vai trò cũ
        DB::table('tai_khoan_vai_tro')->where('tai_khoan_id', $userId)->delete();

        // Thêm vai trò mới
        DB::table('tai_khoan_vai_tro')->insert([
            'tai_khoan_id' => $userId,
            'vai_tro_id' => $vaiTroId,
        ]);

        // Xóa cache quyền
        \App\Helpers\PermissionHelper::clearUserPermissionsCache($userId);
    }

    /**
     * Gán vai trò mặc định cho user mới
     */
    private function assignDefaultPermissionRole($userId, $role): void
    {
        // Map role sang vai_tro_id mặc định
        $roleMap = [
            'admin' => 2,           // Admin
            'dao_tao' => 4,         // Nhân Viên Đào Tạo
            'giang_vien' => 6,      // Giảng Viên
            'sinh_vien' => 7,       // Sinh Viên
        ];

        $vaiTroId = $roleMap[$role] ?? null;

        if ($vaiTroId) {
            DB::table('tai_khoan_vai_tro')->insert([
                'tai_khoan_id' => $userId,
                'vai_tro_id' => $vaiTroId,
            ]);
        }
    }
}

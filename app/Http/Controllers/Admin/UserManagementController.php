<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);

        // Xác định vai trò của mỗi user
        foreach ($users as $user) {
            $user->role = $this->getUserRole($user->email);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,dao_tao,giang_vien,sinh_vien',
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // 1. Tạo user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // 2. Tạo bản ghi vai trò tương ứng
            $this->assignRole($user, $validated['role'], $validated);

            DB::commit();
            return redirect()->route('admin.users.index')
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
        $user->role = $this->getUserRole($user->email);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->role = $this->getUserRole($user->email);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            // Không validate 'role' vì không cho phép đổi vai trò
        ]);

        DB::beginTransaction();
        try {
            // Cập nhật user
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);

            DB::commit();
            return redirect()->route('admin.users.index')
                ->with('success', 'Cập nhật tài khoản thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi: ' . $e->getMessage());
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
        ];

        switch ($role) {
            case 'admin':
                DB::table('admin')->insert($baseData);
                break;
            case 'dao_tao':
                DB::table('dao_tao')->insert($baseData);
                break;
            case 'giang_vien':
                DB::table('giang_vien')->insert(array_merge($baseData, [
                    'ma_giang_vien' => 'GV' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'khoa_id' => 1, // Mặc định
                    'trinh_do_id' => 1, // Mặc định
                ]));
                break;
            case 'sinh_vien':
                DB::table('sinh_vien')->insert(array_merge($baseData, [
                    'ma_sinh_vien' => 'SV' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'nganh_id' => 1, // Mặc định
                    'chuyen_nganh_id' => 1, // Mặc định
                    'khoa_hoc_id' => 1, // Mặc định
                    'trang_thai_hoc_tap_id' => 1, // Mặc định
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
}

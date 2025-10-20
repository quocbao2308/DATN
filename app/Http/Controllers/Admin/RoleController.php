<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeThong\VaiTro;
use App\Models\HeThong\Quyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = VaiTro::withCount('quyens')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Quyen::orderBy('id')->get();

        // Group permissions by category
        $groupedPermissions = $this->groupPermissions($permissions);

        return view('admin.roles.create', compact('groupedPermissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_vai_tro' => 'required|string|max:255|unique:vai_tro,ten_vai_tro',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:quyen,id',
        ], [
            'ten_vai_tro.required' => 'Tên vai trò không được để trống',
            'ten_vai_tro.unique' => 'Tên vai trò đã tồn tại',
            'permissions.*.exists' => 'Quyền không hợp lệ',
        ]);

        DB::beginTransaction();
        try {
            // Create role
            $role = VaiTro::create([
                'ten_vai_tro' => $validated['ten_vai_tro'],
            ]);

            // Attach permissions
            if (!empty($validated['permissions'])) {
                $role->quyens()->attach($validated['permissions']);
            }

            DB::commit();
            Cache::flush();

            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Đã thêm vai trò mới thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified role.
     */
    public function show(VaiTro $role)
    {
        $role->load('quyens');

        // Group permissions by category
        $groupedPermissions = $this->groupPermissions($role->quyens);

        return view('admin.roles.show', compact('role', 'groupedPermissions'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(VaiTro $role)
    {
        $role->load('quyens');
        $permissions = Quyen::orderBy('id')->get();

        // Group permissions by category
        $groupedPermissions = $this->groupPermissions($permissions);

        // Get selected permission IDs
        $selectedPermissions = $role->quyens->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'selectedPermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, VaiTro $role)
    {
        $validated = $request->validate([
            'ten_vai_tro' => 'required|string|max:255|unique:vai_tro,ten_vai_tro,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:quyen,id',
        ], [
            'ten_vai_tro.required' => 'Tên vai trò không được để trống',
            'ten_vai_tro.unique' => 'Tên vai trò đã tồn tại',
            'permissions.*.exists' => 'Quyền không hợp lệ',
        ]);

        DB::beginTransaction();
        try {
            // Update role name
            $role->update([
                'ten_vai_tro' => $validated['ten_vai_tro'],
            ]);

            // Sync permissions (remove old, add new)
            $role->quyens()->sync($validated['permissions'] ?? []);

            DB::commit();
            Cache::flush();

            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Đã cập nhật vai trò thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(VaiTro $role)
    {
        // Check if role is assigned to any users
        $userCount = DB::table('tai_khoan_vai_tro')->where('vai_tro_id', $role->id)->count();

        if ($userCount > 0) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', "Không thể xóa vai trò đang được gán cho {$userCount} người dùng!");
        }

        DB::beginTransaction();
        try {
            // Detach all permissions
            $role->quyens()->detach();

            // Delete role
            $role->delete();

            DB::commit();
            Cache::flush();

            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Đã xóa vai trò thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Group permissions by category.
     */
    private function groupPermissions($permissions)
    {
        return [
            'Quản lý Người dùng' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'nguoi_dung');
            }),
            'Quản lý Sinh viên' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'sinh_vien');
            }),
            'Quản lý Giảng viên' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'giang_vien');
            }),
            'Quản lý Điểm' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'diem');
            }),
            'Quản lý Lớp học' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'lop_hoc');
            }),
            'Quản lý Lịch học' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'lich_hoc');
            }),
            'Quản lý Danh mục' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'quan_ly');
            }),
            'Báo cáo' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'bao_cao');
            }),
            'Hệ thống' => $permissions->filter(function ($p) {
                return str_contains($p->ma_quyen, 'he_thong');
            }),
        ];
    }
}

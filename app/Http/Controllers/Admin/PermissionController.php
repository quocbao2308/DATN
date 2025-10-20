<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeThong\Quyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $permissions = Quyen::query()
            ->when($search, function ($query, $search) {
                $query->where('ma_quyen', 'like', "%{$search}%")
                    ->orWhere('mo_ta', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->paginate(15);

        return view('admin.permissions.index', compact('permissions', 'search'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_quyen' => 'required|string|max:255|unique:quyen,ma_quyen|regex:/^[a-z_]+$/',
            'mo_ta' => 'nullable|string|max:255',
        ], [
            'ma_quyen.required' => 'Mã quyền không được để trống',
            'ma_quyen.unique' => 'Mã quyền đã tồn tại',
            'ma_quyen.regex' => 'Mã quyền chỉ được chứa chữ thường và dấu gạch dưới',
            'mo_ta.max' => 'Mô tả không được vượt quá 255 ký tự',
        ]);

        Quyen::create($validated);

        // Clear permission cache
        Cache::flush();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Đã thêm quyền mới thành công!');
    }

    /**
     * Display the specified permission.
     */
    public function show(Quyen $permission)
    {
        $permission->load('vaiTros');
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Quyen $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Quyen $permission)
    {
        $validated = $request->validate([
            'ma_quyen' => 'required|string|max:255|unique:quyen,ma_quyen,' . $permission->id . '|regex:/^[a-z_]+$/',
            'mo_ta' => 'nullable|string|max:255',
        ], [
            'ma_quyen.required' => 'Mã quyền không được để trống',
            'ma_quyen.unique' => 'Mã quyền đã tồn tại',
            'ma_quyen.regex' => 'Mã quyền chỉ được chứa chữ thường và dấu gạch dưới',
            'mo_ta.max' => 'Mô tả không được vượt quá 255 ký tự',
        ]);

        $permission->update($validated);

        // Clear permission cache
        Cache::flush();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Đã cập nhật quyền thành công!');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Quyen $permission)
    {
        // Check if permission is assigned to any roles
        if ($permission->vaiTros()->count() > 0) {
            return redirect()
                ->route('admin.permissions.index')
                ->with('error', 'Không thể xóa quyền đang được gán cho vai trò!');
        }

        $permission->delete();

        // Clear permission cache
        Cache::flush();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Đã xóa quyền thành công!');
    }
}

<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PermissionHelper
{
    /**
     * Kiểm tra user có quyền hay không
     */
    public static function hasPermission($permission): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        // Cache quyền trong 60 phút để tăng performance
        $cacheKey = "user_permissions_{$user->id}";

        $permissions = Cache::remember($cacheKey, 3600, function () use ($user) {
            return DB::table('tai_khoan_vai_tro')
                ->join('vai_tro_quyen', 'tai_khoan_vai_tro.vai_tro_id', '=', 'vai_tro_quyen.vai_tro_id')
                ->join('quyen', 'vai_tro_quyen.quyen_id', '=', 'quyen.id')
                ->where('tai_khoan_vai_tro.tai_khoan_id', $user->id)
                ->pluck('quyen.ma_quyen')
                ->toArray();
        });

        return in_array($permission, $permissions);
    }

    /**
     * Kiểm tra user có một trong các quyền
     */
    public static function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (self::hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Kiểm tra user có tất cả các quyền
     */
    public static function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!self::hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Lấy danh sách tất cả quyền của user
     */
    public static function getUserPermissions(): array
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        $cacheKey = "user_permissions_{$user->id}";

        return Cache::remember($cacheKey, 3600, function () use ($user) {
            return DB::table('tai_khoan_vai_tro')
                ->join('vai_tro_quyen', 'tai_khoan_vai_tro.vai_tro_id', '=', 'vai_tro_quyen.vai_tro_id')
                ->join('quyen', 'vai_tro_quyen.quyen_id', '=', 'quyen.id')
                ->where('tai_khoan_vai_tro.tai_khoan_id', $user->id)
                ->select('quyen.ma_quyen', 'quyen.mo_ta')
                ->get()
                ->toArray();
        });
    }

    /**
     * Lấy thông tin vai trò của user
     */
    public static function getUserRole()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $cacheKey = "user_role_{$user->id}";

        return Cache::remember($cacheKey, 3600, function () use ($user) {
            return DB::table('tai_khoan_vai_tro')
                ->join('vai_tro', 'tai_khoan_vai_tro.vai_tro_id', '=', 'vai_tro.id')
                ->where('tai_khoan_vai_tro.tai_khoan_id', $user->id)
                ->select('vai_tro.id', 'vai_tro.ten_vai_tro')
                ->first();
        });
    }

    /**
     * Xóa cache quyền của user
     */
    public static function clearUserPermissionsCache($userId = null): void
    {
        if ($userId === null) {
            $userId = Auth::id();
        }

        if ($userId) {
            Cache::forget("user_permissions_{$userId}");
            Cache::forget("user_role_{$userId}");
        }
    }
}

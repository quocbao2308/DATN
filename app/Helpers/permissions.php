<?php

use App\Helpers\PermissionHelper;

if (!function_exists('hasPermission')) {
    /**
     * Kiểm tra user có quyền
     */
    function hasPermission($permission): bool
    {
        return PermissionHelper::hasPermission($permission);
    }
}

if (!function_exists('hasAnyPermission')) {
    /**
     * Kiểm tra user có một trong các quyền
     */
    function hasAnyPermission(array $permissions): bool
    {
        return PermissionHelper::hasAnyPermission($permissions);
    }
}

if (!function_exists('hasAllPermissions')) {
    /**
     * Kiểm tra user có tất cả các quyền
     */
    function hasAllPermissions(array $permissions): bool
    {
        return PermissionHelper::hasAllPermissions($permissions);
    }
}

if (!function_exists('getUserPermissions')) {
    /**
     * Lấy danh sách quyền của user
     */
    function getUserPermissions(): array
    {
        return PermissionHelper::getUserPermissions();
    }
}

if (!function_exists('getUserRole')) {
    /**
     * Lấy vai trò của user
     */
    function getUserRole()
    {
        return PermissionHelper::getUserRole();
    }
}

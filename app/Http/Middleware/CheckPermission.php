<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\PermissionHelper;

class CheckPermission
{
    /**
     * Handle an incoming request.
     * 
     * Kiểm tra xem user có quyền truy cập hay không
     * 
     * Usage: Route::get('/path', [Controller::class, 'method'])->middleware('permission:ten_quyen');
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission  - Tên quyền cần kiểm tra (VD: 'xem_sinh_vien', 'them_nguoi_dung')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        // Kiểm tra quyền
        if (!PermissionHelper::hasPermission($permission)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này. Quyền yêu cầu: ' . $permission);
        }

        return $next($request);
    }
}

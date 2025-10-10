<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request - Redirect user đến dashboard phù hợp với vai trò
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $email = $user->email;

            // Kiểm tra vai trò theo thứ tự ưu tiên

            // 1. Kiểm tra Admin
            $isAdmin = DB::table('admin')->where('email', $email)->exists();
            if ($isAdmin && !$request->is('admin*')) {
                return redirect()->route('admin.dashboard');
            }

            // 2. Kiểm tra Đào tạo
            $isDaoTao = DB::table('dao_tao')->where('email', $email)->exists();
            if ($isDaoTao && !$request->is('dao-tao*')) {
                return redirect()->route('dao-tao.dashboard');
            }

            // 3. Kiểm tra Giảng viên
            $isGiangVien = DB::table('giang_vien')->where('email', $email)->exists();
            if ($isGiangVien && !$request->is('giang-vien*')) {
                return redirect()->route('giang-vien.dashboard');
            }

            // 4. Kiểm tra Sinh viên
            $isSinhVien = DB::table('sinh_vien')->where('email', $email)->exists();
            if ($isSinhVien && !$request->is('sinh-vien*')) {
                return redirect()->route('sinh-vien.dashboard');
            }
        }

        return $next($request);
    }
}

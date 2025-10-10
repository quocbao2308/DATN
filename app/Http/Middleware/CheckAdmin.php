<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        $user = auth()->user();

        // Kiểm tra xem email có trong bảng admin không
        $admin = \Illuminate\Support\Facades\DB::table('admin')
            ->where('email', $user->email)
            ->first();

        if (!$admin) {
            abort(403, 'Bạn không có quyền truy cập khu vực Admin. Chỉ tài khoản Admin mới được phép.');
        }

        return $next($request);
    }
}

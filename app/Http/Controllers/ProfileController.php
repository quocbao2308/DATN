<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Xác định vai trò của user
        $role = $this->getUserRole($user->email);

        // Lấy thông tin chi tiết theo vai trò
        $details = null;

        if ($role === 'Admin') {
            $details = DB::table('admin')
                ->where('email', $user->email)
                ->first();
        } elseif ($role === 'Đào tạo') {
            $details = DB::table('dao_tao')
                ->where('email', $user->email)
                ->first();
        } elseif ($role === 'Giảng viên') {
            $details = DB::table('giang_vien')
                ->leftJoin('khoa', 'giang_vien.khoa_id', '=', 'khoa.id')
                ->leftJoin('dm_trinh_do', 'giang_vien.trinh_do_id', '=', 'dm_trinh_do.id')
                ->where(function ($q) use ($user) {
                    $q->where('giang_vien.user_id', $user->id)
                        ->orWhere('giang_vien.email', $user->email);
                })
                ->select('giang_vien.*', 'khoa.ten_khoa', 'dm_trinh_do.ten_trinh_do')
                ->first();
        } elseif ($role === 'Sinh viên') {
            $details = DB::table('sinh_vien')
                ->leftJoin('nganh', 'sinh_vien.nganh_id', '=', 'nganh.id')
                ->leftJoin('chuyen_nganh', 'sinh_vien.chuyen_nganh_id', '=', 'chuyen_nganh.id')
                ->leftJoin('khoa_hoc', 'sinh_vien.khoa_hoc_id', '=', 'khoa_hoc.id')
                ->leftJoin('trang_thai_hoc_tap', 'sinh_vien.trang_thai_hoc_tap_id', '=', 'trang_thai_hoc_tap.id')
                ->where(function ($q) use ($user) {
                    $q->where('sinh_vien.user_id', $user->id)
                        ->orWhere('sinh_vien.email', $user->email);
                })
                ->select(
                    'sinh_vien.*',
                    'nganh.ten_nganh',
                    'chuyen_nganh.ten_chuyen_nganh',
                    'khoa_hoc.ten_khoa_hoc',
                    'trang_thai_hoc_tap.ten_trang_thai'
                )
                ->first();
        }

        return view('profile.edit', [
            'user' => $user,
            'role' => $role,
            'details' => $details
        ]);
    }

    /**
     * Xác định vai trò của user
     */
    private function getUserRole($email)
    {
        if (DB::table('admin')->where('email', $email)->exists()) {
            return 'Admin';
        } elseif (DB::table('dao_tao')->where('email', $email)->exists()) {
            return 'Đào tạo';
        } elseif (DB::table('giang_vien')->where('email', $email)->exists()) {
            return 'Giảng viên';
        } elseif (DB::table('sinh_vien')->where('email', $email)->exists()) {
            return 'Sinh viên';
        }
        return 'User';
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

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
                ->select('admin.*')
                ->where('email', $user->email)
                ->first();
        } elseif ($role === 'Đào tạo') {
            $details = DB::table('dao_tao')
                ->select('dao_tao.*')
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

        // Lấy thông tin vai trò và quyền
        $userRole = DB::table('tai_khoan_vai_tro')
            ->join('vai_tro', 'tai_khoan_vai_tro.vai_tro_id', '=', 'vai_tro.id')
            ->where('tai_khoan_vai_tro.tai_khoan_id', $user->id)
            ->select('vai_tro.id', 'vai_tro.ten_vai_tro')
            ->first();

        $permissions = [];
        if ($userRole) {
            $permissions = DB::table('vai_tro_quyen')
                ->join('quyen', 'vai_tro_quyen.quyen_id', '=', 'quyen.id')
                ->where('vai_tro_quyen.vai_tro_id', $userRole->id)
                ->select('quyen.ma_quyen', 'quyen.mo_ta')
                ->get();
        }

        return view('profile.edit', [
            'user' => $user,
            'role' => $role,
            'details' => $details,
            'userRole' => $userRole,
            'permissions' => $permissions
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
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Xử lý upload ảnh đại diện - CHỈ cho Admin, Đào tạo, Giảng viên
        if ($request->hasFile('anh_dai_dien')) {
            $role = $this->getUserRole($user->email);

            // Sinh viên KHÔNG được tự upload ảnh
            if ($role === 'Sinh viên') {
                return Redirect::route('profile.edit')
                    ->with('error', 'Sinh viên không thể tự thay đổi ảnh đại diện. Vui lòng liên hệ phòng Đào tạo.');
            }

            // Upload file
            $file = $request->file('anh_dai_dien');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $filename, 'public');

            // Cập nhật ảnh vào bảng tương ứng
            if ($role === 'Admin') {
                DB::table('admin')->where('email', $user->email)->update([
                    'anh_dai_dien' => $path
                ]);
            } elseif ($role === 'Đào tạo') {
                DB::table('dao_tao')->where('email', $user->email)->update([
                    'anh_dai_dien' => $path
                ]);
            } elseif ($role === 'Giảng viên') {
                DB::table('giang_vien')->where('email', $user->email)->update([
                    'anh_dai_dien' => $path
                ]);
            }
        }

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

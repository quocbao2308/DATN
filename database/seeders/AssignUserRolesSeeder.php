<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map role sang vai_tro_id (Đã cập nhật: chỉ 6 vai trò)
        $roleMap = [
            'admin' => 1,           // Admin (toàn quyền)
            'dao_tao' => 3,         // Nhân Viên Đào Tạo
            'giang_vien' => 5,      // Giảng Viên
            'sinh_vien' => 6,       // Sinh Viên
        ];

        // Lấy tất cả users
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Xác định vai trò
            $role = null;
            if (DB::table('admin')->where('user_id', $user->id)->exists()) {
                $role = 'admin';
            } elseif (DB::table('dao_tao')->where('user_id', $user->id)->exists()) {
                $role = 'dao_tao';
            } elseif (DB::table('giang_vien')->where('user_id', $user->id)->exists()) {
                $role = 'giang_vien';
            } elseif (DB::table('sinh_vien')->where('user_id', $user->id)->exists()) {
                $role = 'sinh_vien';
            }

            if ($role && isset($roleMap[$role])) {
                // Gán vai trò
                DB::table('tai_khoan_vai_tro')->updateOrInsert(
                    ['tai_khoan_id' => $user->id],
                    ['vai_tro_id' => $roleMap[$role]]
                );

                $this->command->info("✅ Đã gán vai trò cho user: {$user->email}");
            }
        }

        $this->command->info('✅ Hoàn tất gán vai trò cho tất cả users!');
    }
}

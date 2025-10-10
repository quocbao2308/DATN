<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleDataSeeder extends Seeder
{
    /**
     * Run the database seeds - Tạo dữ liệu cho các bảng admin, dao_tao, giang_vien, sinh_vien
     */
    public function run(): void
    {
        // 1. Tạo bản ghi Admin
        DB::table('admin')->updateOrInsert(
            ['email' => 'admin@smis.edu.vn'],
            [
                'ho_ten' => 'Admin Hệ Thống',
                'email' => 'admin@smis.edu.vn',
                'so_dien_thoai' => '0987654321',
            ]
        );

        // 2. Tạo bản ghi Đào tạo
        DB::table('dao_tao')->updateOrInsert(
            ['email' => 'daotao@smis.edu.vn'],
            [
                'ho_ten' => 'Phòng Đào Tạo',
                'email' => 'daotao@smis.edu.vn',
                'so_dien_thoai' => '0912345678',
            ]
        );

        // 3. Tạo bản ghi Giảng viên
        DB::table('giang_vien')->updateOrInsert(
            ['email' => 'giangvien@smis.edu.vn'],
            [
                'ma_giang_vien' => 'GV001',
                'ho_ten' => 'Nguyễn Văn A',
                'email' => 'giangvien@smis.edu.vn',
                'so_dien_thoai' => '0901234567',
                'khoa_id' => 1, // Giả sử khoa có id = 1
                'trinh_do_id' => 1, // Giả sử trình độ có id = 1
            ]
        );

        // 4. Tạo bản ghi Sinh viên
        DB::table('sinh_vien')->updateOrInsert(
            ['email' => 'sinhvien@smis.edu.vn'],
            [
                'ma_sinh_vien' => 'SV001',
                'ho_ten' => 'Nguyễn Văn B',
                'email' => 'sinhvien@smis.edu.vn',
                'so_dien_thoai' => '0909876543',
                'nganh_id' => 1, // Giả sử ngành có id = 1
                'chuyen_nganh_id' => 1, // Giả sử chuyên ngành có id = 1
                'khoa_hoc_id' => 1, // Giả sử khóa học có id = 1
                'trang_thai_hoc_tap_id' => 1, // Giả sử trạng thái có id = 1
            ]
        );

        $this->command->info('✅ Đã tạo dữ liệu vai trò cho 4 tài khoản:');
        $this->command->info('   👤 Admin: admin@smis.edu.vn / 123456 → /admin/dashboard');
        $this->command->info('   👤 Đào tạo: daotao@smis.edu.vn / 123456 → /dao-tao/dashboard');
        $this->command->info('   👤 Giảng viên: giangvien@smis.edu.vn / 123456 → /giang-vien/dashboard');
        $this->command->info('   👤 Sinh viên: sinhvien@smis.edu.vn / 123456 → /sinh-vien/dashboard');
    }
}

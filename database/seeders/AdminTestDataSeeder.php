<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Seed Khoa (Faculties)
        $khoaIds = [];
        $khoas = [
            ['ten_khoa' => 'Công nghệ thông tin'],
            ['ten_khoa' => 'Kinh tế'],
            ['ten_khoa' => 'Ngoại ngữ'],
            ['ten_khoa' => 'Kỹ thuật'],
        ];

        foreach ($khoas as $khoa) {
            $khoaIds[] = DB::table('khoa')->insertGetId(array_merge($khoa, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Nganh (Majors)
        $nganhIds = [];
        $nganhs = [
            ['ten_nganh' => 'Công nghệ phần mềm', 'khoa_id' => $khoaIds[0]],
            ['ten_nganh' => 'Hệ thống thông tin', 'khoa_id' => $khoaIds[0]],
            ['ten_nganh' => 'An toàn thông tin', 'khoa_id' => $khoaIds[0]],
            ['ten_nganh' => 'Kế toán', 'khoa_id' => $khoaIds[1]],
            ['ten_nganh' => 'Quản trị kinh doanh', 'khoa_id' => $khoaIds[1]],
            ['ten_nganh' => 'Tiếng Anh', 'khoa_id' => $khoaIds[2]],
        ];

        foreach ($nganhs as $nganh) {
            $nganhIds[] = DB::table('nganh')->insertGetId(array_merge($nganh, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Chuyen Nganh (Specializations)
        $chuyenNganhs = [
            ['ten_chuyen_nganh' => 'Phát triển ứng dụng Web', 'nganh_id' => $nganhIds[0]],
            ['ten_chuyen_nganh' => 'Phát triển ứng dụng Mobile', 'nganh_id' => $nganhIds[0]],
            ['ten_chuyen_nganh' => 'AI và Machine Learning', 'nganh_id' => $nganhIds[0]],
            ['ten_chuyen_nganh' => 'Kế toán tài chính', 'nganh_id' => $nganhIds[3]],
            ['ten_chuyen_nganh' => 'Kế toán quản trị', 'nganh_id' => $nganhIds[3]],
        ];

        foreach ($chuyenNganhs as $chuyenNganh) {
            DB::table('chuyen_nganh')->insert(array_merge($chuyenNganh, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Dm Trinh Do (Academic Degrees)
        $trinhDos = [
            ['ten_trinh_do' => 'Cao đẳng'],
            ['ten_trinh_do' => 'Đại học'],
            ['ten_trinh_do' => 'Thạc sĩ'],
            ['ten_trinh_do' => 'Tiến sĩ'],
        ];

        foreach ($trinhDos as $trinhDo) {
            DB::table('dm_trinh_do')->insert(array_merge($trinhDo, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Trang Thai Hoc Tap (Study Status)
        $trangThais = [
            ['ten_trang_thai' => 'Đang học'],
            ['ten_trang_thai' => 'Bảo lưu'],
            ['ten_trang_thai' => 'Thôi học'],
            ['ten_trang_thai' => 'Tốt nghiệp'],
            ['ten_trang_thai' => 'Chuyển trường'],
        ];

        foreach ($trangThais as $trangThai) {
            DB::table('trang_thai_hoc_tap')->insert(array_merge($trangThai, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Khoa Hoc (Course Years)
        $khoaHocIds = [];
        $khoaHocs = [
            ['ten_khoa_hoc' => 'Khóa 2020-2024', 'nam_bat_dau' => 2020, 'nam_ket_thuc' => 2024],
            ['ten_khoa_hoc' => 'Khóa 2021-2025', 'nam_bat_dau' => 2021, 'nam_ket_thuc' => 2025],
            ['ten_khoa_hoc' => 'Khóa 2022-2026', 'nam_bat_dau' => 2022, 'nam_ket_thuc' => 2026],
            ['ten_khoa_hoc' => 'Khóa 2023-2027', 'nam_bat_dau' => 2023, 'nam_ket_thuc' => 2027],
            ['ten_khoa_hoc' => 'Khóa 2024-2028', 'nam_bat_dau' => 2024, 'nam_ket_thuc' => 2028],
        ];

        foreach ($khoaHocs as $khoaHoc) {
            $khoaHocIds[] = DB::table('khoa_hoc')->insertGetId(array_merge($khoaHoc, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Hoc Ky (Semesters)
        $hocKys = [
            ['ten_hoc_ky' => 'HK1 2023-2024', 'nam_bat_dau' => 2023, 'nam_ket_thuc' => 2024, 'ngay_bat_dau' => '2023-09-01', 'ngay_ket_thuc' => '2024-01-15'],
            ['ten_hoc_ky' => 'HK2 2023-2024', 'nam_bat_dau' => 2023, 'nam_ket_thuc' => 2024, 'ngay_bat_dau' => '2024-02-01', 'ngay_ket_thuc' => '2024-06-15'],
            ['ten_hoc_ky' => 'HK1 2024-2025', 'nam_bat_dau' => 2024, 'nam_ket_thuc' => 2025, 'ngay_bat_dau' => '2024-09-01', 'ngay_ket_thuc' => '2025-01-15'],
            ['ten_hoc_ky' => 'HK2 2024-2025', 'nam_bat_dau' => 2024, 'nam_ket_thuc' => 2025, 'ngay_bat_dau' => '2025-02-01', 'ngay_ket_thuc' => '2025-06-15'],
        ];

        foreach ($hocKys as $hocKy) {
            DB::table('hoc_ky')->insert(array_merge($hocKy, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Seed Phong Hoc (Classrooms)
        $phongHocs = [
            ['ma_phong' => 'A101', 'suc_chua' => 50, 'vi_tri' => 'Tòa A, Tầng 1'],
            ['ma_phong' => 'A102', 'suc_chua' => 50, 'vi_tri' => 'Tòa A, Tầng 1'],
            ['ma_phong' => 'A201', 'suc_chua' => 40, 'vi_tri' => 'Tòa A, Tầng 2'],
            ['ma_phong' => 'A202', 'suc_chua' => 40, 'vi_tri' => 'Tòa A, Tầng 2'],
            ['ma_phong' => 'B101', 'suc_chua' => 200, 'vi_tri' => 'Tòa B, Tầng 1'],
            ['ma_phong' => 'B201', 'suc_chua' => 30, 'vi_tri' => 'Tòa B, Tầng 2'],
            ['ma_phong' => 'C101', 'suc_chua' => 60, 'vi_tri' => 'Tòa C, Tầng 1'],
        ];

        foreach ($phongHocs as $phongHoc) {
            DB::table('phong_hoc')->insert(array_merge($phongHoc, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        $this->command->info('✅ Admin test data seeded successfully!');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HocKySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách khóa học
        $khoaHocs = DB::table('khoa_hoc')->get();

        if ($khoaHocs->isEmpty()) {
            $this->command->warn('⚠️ Chưa có dữ liệu khóa học. Vui lòng seed khóa học trước!');

            // Tạo khóa học mẫu
            $khoaHocData = [];
            for ($year = 2021; $year <= 2025; $year++) {
                $khoaHocData[] = [
                    'ten_khoa_hoc' => 'Khóa ' . $year,
                    'nam_bat_dau' => $year,
                    'nam_ket_thuc' => $year + 4,
                    'mo_ta' => 'Khóa học bắt đầu từ năm ' . $year . ' đến ' . ($year + 4)
                ];
            }

            DB::table('khoa_hoc')->insert($khoaHocData);
            $khoaHocs = DB::table('khoa_hoc')->get();
            $this->command->info('✅ Đã tạo ' . count($khoaHocData) . ' khóa học mẫu');
        }

        $hocKys = [];

        foreach ($khoaHocs as $khoaHoc) {
            $namBatDau = $khoaHoc->nam_bat_dau;

            // Mỗi khóa học có 8 học kỳ (4 năm x 2 học kỳ)
            for ($nam = 0; $nam < 4; $nam++) {
                $namHienTai = $namBatDau + $nam;

                // Học kỳ 1 (Fall) - Tháng 9-12
                $hocKys[] = [
                    'khoa_hoc_id' => $khoaHoc->id,
                    'ten_hoc_ky' => 'Kỳ 1 năm ' . $namHienTai,
                    'nam_bat_dau' => $namHienTai,
                    'nam_ket_thuc' => $namHienTai + 1,
                    'ngay_bat_dau' => $namHienTai . '-09-01',
                    'ngay_ket_thuc' => $namHienTai . '-12-31',
                    'mo_ta' => 'Học kỳ 1 năm ' . $namHienTai . ' (Tháng 9-12/' . $namHienTai . ')'
                ];

                // Học kỳ 2 (Spring) - Tháng 1-5
                $hocKys[] = [
                    'khoa_hoc_id' => $khoaHoc->id,
                    'ten_hoc_ky' => 'Kỳ 2 năm ' . ($namHienTai + 1),
                    'nam_bat_dau' => $namHienTai,
                    'nam_ket_thuc' => $namHienTai + 1,
                    'ngay_bat_dau' => ($namHienTai + 1) . '-01-15',
                    'ngay_ket_thuc' => ($namHienTai + 1) . '-05-31',
                    'mo_ta' => 'Học kỳ 2 năm ' . ($namHienTai + 1) . ' (Tháng 1-5/' . ($namHienTai + 1) . ')'
                ];
            }
        }

        DB::table('hoc_ky')->insert($hocKys);

        $this->command->info('✅ Đã seed ' . count($hocKys) . ' học kỳ cho ' . count($khoaHocs) . ' khóa học');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phongHocs = [];

        // Toà A - Phòng học lý thuyết
        for ($i = 1; $i <= 10; $i++) {
            $phongHocs[] = [
                'ma_phong' => 'A' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'ten_phong' => 'Phòng A' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'suc_chua' => rand(40, 60),
                'vi_tri' => 'Toà A - Tầng ' . ceil($i / 2),
                'loai_phong' => 'Lý thuyết',
                'trang_thai' => 'Hoạt động',
                'mo_ta' => 'Phòng học lý thuyết tại toà A, trang bị bảng thông minh và máy chiếu'
            ];
        }

        // Toà B - Phòng học lý thuyết
        for ($i = 1; $i <= 10; $i++) {
            $phongHocs[] = [
                'ma_phong' => 'B' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'ten_phong' => 'Phòng B' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'suc_chua' => rand(40, 60),
                'vi_tri' => 'Toà B - Tầng ' . ceil($i / 2),
                'loai_phong' => 'Lý thuyết',
                'trang_thai' => 'Hoạt động',
                'mo_ta' => 'Phòng học lý thuyết tại toà B, trang bị bảng thông minh và máy chiếu'
            ];
        }

        // Toà C - Phòng máy tính
        for ($i = 1; $i <= 8; $i++) {
            $phongHocs[] = [
                'ma_phong' => 'C' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'ten_phong' => 'Phòng Máy C' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'suc_chua' => rand(30, 40),
                'vi_tri' => 'Toà C - Tầng ' . ceil($i / 2),
                'loai_phong' => 'Máy tính',
                'trang_thai' => 'Hoạt động',
                'mo_ta' => 'Phòng máy tính tại toà C, trang bị máy tính cấu hình cao phục vụ thực hành'
            ];
        }

        // Toà D - Phòng thực hành và hội trường
        for ($i = 1; $i <= 5; $i++) {
            $phongHocs[] = [
                'ma_phong' => 'D' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'ten_phong' => 'Phòng Thực hành D' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'suc_chua' => rand(30, 50),
                'vi_tri' => 'Toà D - Tầng ' . ceil($i / 2),
                'loai_phong' => 'Thực hành',
                'trang_thai' => 'Hoạt động',
                'mo_ta' => 'Phòng thực hành tại toà D, trang bị thiết bị chuyên dụng'
            ];
        }

        // Thêm 2 hội trường lớn
        $phongHocs[] = [
            'ma_phong' => 'D06',
            'ten_phong' => 'Hội trường A',
            'suc_chua' => 200,
            'vi_tri' => 'Toà D - Tầng 1',
            'loai_phong' => 'Hội trường',
            'trang_thai' => 'Hoạt động',
            'mo_ta' => 'Hội trường lớn phục vụ các sự kiện, hội thảo và lễ khai giảng'
        ];

        $phongHocs[] = [
            'ma_phong' => 'D07',
            'ten_phong' => 'Hội trường B',
            'suc_chua' => 150,
            'vi_tri' => 'Toà D - Tầng 2',
            'loai_phong' => 'Hội trường',
            'trang_thai' => 'Hoạt động',
            'mo_ta' => 'Hội trường phục vụ các buổi hội thảo, seminar và bảo vệ đồ án'
        ];

        // Thêm một vài phòng đang bảo trì
        $phongHocs[] = [
            'ma_phong' => 'C09',
            'ten_phong' => 'Phòng Máy C09',
            'suc_chua' => 35,
            'vi_tri' => 'Toà C - Tầng 5',
            'loai_phong' => 'Máy tính',
            'trang_thai' => 'Bảo trì',
            'mo_ta' => 'Phòng máy tính đang nâng cấp hệ thống'
        ];

        DB::table('phong_hoc')->insert($phongHocs);

        $this->command->info('✅ Đã seed ' . count($phongHocs) . ' phòng học (Toà A: 10, Toà B: 10, Toà C: 9, Toà D: 7)');
    }
}

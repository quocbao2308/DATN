<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhoaHocSeeder extends Seeder
{
    public function run(): void
    {
        $khoaHocs = [
            ['ten_khoa_hoc' => 'K47', 'nam_bat_dau' => 2019, 'nam_ket_thuc' => 2023],
            ['ten_khoa_hoc' => 'K48', 'nam_bat_dau' => 2020, 'nam_ket_thuc' => 2024],
            ['ten_khoa_hoc' => 'K49', 'nam_bat_dau' => 2021, 'nam_ket_thuc' => 2025],
            ['ten_khoa_hoc' => 'K50', 'nam_bat_dau' => 2022, 'nam_ket_thuc' => 2026],
            ['ten_khoa_hoc' => 'K51', 'nam_bat_dau' => 2023, 'nam_ket_thuc' => 2027],
            ['ten_khoa_hoc' => 'K52', 'nam_bat_dau' => 2024, 'nam_ket_thuc' => 2028],
        ];

        DB::table('khoa_hoc')->insert($khoaHocs);
    }
}

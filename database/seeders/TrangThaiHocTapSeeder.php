<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrangThaiHocTapSeeder extends Seeder
{
    public function run(): void
    {
        $trangThais = [
            ['ten_trang_thai' => 'Đang học'],
            ['ten_trang_thai' => 'Bảo lưu'],
            ['ten_trang_thai' => 'Thôi học'],
            ['ten_trang_thai' => 'Tốt nghiệp'],
            ['ten_trang_thai' => 'Chuyển trường'],
        ];

        DB::table('trang_thai_hoc_tap')->insert($trangThais);
    }
}

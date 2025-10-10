<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $khoas = [
            ['ten_khoa' => 'Khoa Công nghệ thông tin'],
            ['ten_khoa' => 'Khoa Kinh tế'],
            ['ten_khoa' => 'Khoa Quản trị kinh doanh'],
            ['ten_khoa' => 'Khoa Kế toán - Kiểm toán'],
            ['ten_khoa' => 'Khoa Luật'],
            ['ten_khoa' => 'Khoa Ngoại ngữ'],
            ['ten_khoa' => 'Khoa Kỹ thuật - Công nghệ'],
            ['ten_khoa' => 'Khoa Điện - Điện tử'],
            ['ten_khoa' => 'Khoa Xây dựng'],
            ['ten_khoa' => 'Khoa Du lịch - Khách sạn'],
        ];

        DB::table('khoa')->insert($khoas);
    }
}

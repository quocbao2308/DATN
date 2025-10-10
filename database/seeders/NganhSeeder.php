<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NganhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nganhs = [
            // Khoa Công nghệ thông tin (khoa_id = 1)
            ['ten_nganh' => 'Công nghệ thông tin', 'khoa_id' => 1],
            ['ten_nganh' => 'Kỹ thuật phần mềm', 'khoa_id' => 1],
            ['ten_nganh' => 'Hệ thống thông tin', 'khoa_id' => 1],
            ['ten_nganh' => 'Khoa học máy tính', 'khoa_id' => 1],
            ['ten_nganh' => 'An toàn thông tin', 'khoa_id' => 1],

            // Khoa Kinh tế (khoa_id = 2)
            ['ten_nganh' => 'Kinh tế học', 'khoa_id' => 2],
            ['ten_nganh' => 'Kinh tế đối ngoại', 'khoa_id' => 2],
            ['ten_nganh' => 'Kinh tế phát triển', 'khoa_id' => 2],
            ['ten_nganh' => 'Tài chính - Ngân hàng', 'khoa_id' => 2],

            // Khoa Quản trị kinh doanh (khoa_id = 3)
            ['ten_nganh' => 'Quản trị kinh doanh', 'khoa_id' => 3],
            ['ten_nganh' => 'Marketing', 'khoa_id' => 3],
            ['ten_nganh' => 'Quản trị nhân lực', 'khoa_id' => 3],
            ['ten_nganh' => 'Logistics và Quản lý chuỗi cung ứng', 'khoa_id' => 3],

            // Khoa Kế toán - Kiểm toán (khoa_id = 4)
            ['ten_nganh' => 'Kế toán', 'khoa_id' => 4],
            ['ten_nganh' => 'Kiểm toán', 'khoa_id' => 4],
            ['ten_nganh' => 'Kế toán - Tài chính doanh nghiệp', 'khoa_id' => 4],

            // Khoa Luật (khoa_id = 5)
            ['ten_nganh' => 'Luật kinh tế', 'khoa_id' => 5],
            ['ten_nganh' => 'Luật thương mại quốc tế', 'khoa_id' => 5],
            ['ten_nganh' => 'Luật hành chính', 'khoa_id' => 5],

            // Khoa Ngoại ngữ (khoa_id = 6)
            ['ten_nganh' => 'Ngôn ngữ Anh', 'khoa_id' => 6],
            ['ten_nganh' => 'Ngôn ngữ Trung Quốc', 'khoa_id' => 6],
            ['ten_nganh' => 'Ngôn ngữ Nhật', 'khoa_id' => 6],
            ['ten_nganh' => 'Ngôn ngữ Hàn Quốc', 'khoa_id' => 6],

            // Khoa Kỹ thuật - Công nghệ (khoa_id = 7)
            ['ten_nganh' => 'Kỹ thuật cơ khí', 'khoa_id' => 7],
            ['ten_nganh' => 'Kỹ thuật ô tô', 'khoa_id' => 7],
            ['ten_nganh' => 'Công nghệ kỹ thuật cơ điện tử', 'khoa_id' => 7],

            // Khoa Điện - Điện tử (khoa_id = 8)
            ['ten_nganh' => 'Kỹ thuật điện', 'khoa_id' => 8],
            ['ten_nganh' => 'Kỹ thuật điện tử - Viễn thông', 'khoa_id' => 8],
            ['ten_nganh' => 'Tự động hóa', 'khoa_id' => 8],

            // Khoa Xây dựng (khoa_id = 9)
            ['ten_nganh' => 'Kỹ thuật xây dựng', 'khoa_id' => 9],
            ['ten_nganh' => 'Kiến trúc', 'khoa_id' => 9],
            ['ten_nganh' => 'Quản lý xây dựng', 'khoa_id' => 9],

            // Khoa Du lịch - Khách sạn (khoa_id = 10)
            ['ten_nganh' => 'Quản trị khách sạn', 'khoa_id' => 10],
            ['ten_nganh' => 'Quản trị dịch vụ du lịch và lữ hành', 'khoa_id' => 10],
        ];

        DB::table('nganh')->insert($nganhs);
    }
}

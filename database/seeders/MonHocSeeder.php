<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonHocSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mon_hoc')->insert([
            [
                'ma_mon' => 'MH001',
                'ten_mon' => 'Lập trình C++ cơ bản',
                'so_tin_chi' => 3,
                'mo_ta' => 'Học các kiến thức nền tảng về ngôn ngữ lập trình C++, bao gồm biến, hàm, cấu trúc điều khiển và mảng.',
                'loai_mon' => 'Chuyên ngành cơ bản',
                'hinh_thuc_day' => 'offline',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
            [
                'ma_mon' => 'MH002',
                'ten_mon' => 'Cơ sở dữ liệu',
                'so_tin_chi' => 3,
                'mo_ta' => 'Giới thiệu các khái niệm về mô hình dữ liệu, SQL, thiết kế cơ sở dữ liệu và tối ưu truy vấn.',
                'loai_mon' => 'Bắt buộc',
                'hinh_thuc_day' => 'hybrid',
                'thoi_luong' => 50,
                'so_buoi' => 16,
            ],
            [
                'ma_mon' => 'MH003',
                'ten_mon' => 'Cấu trúc dữ liệu và giải thuật',
                'so_tin_chi' => 4,
                'mo_ta' => 'Nghiên cứu về các cấu trúc dữ liệu như danh sách, ngăn xếp, hàng đợi, cây, đồ thị và thuật toán sắp xếp, tìm kiếm.',
                'loai_mon' => 'Chuyên ngành bắt buộc',
                'hinh_thuc_day' => 'offline',
                'thoi_luong' => 60,
                'so_buoi' => 20,
            ],
            [
                'ma_mon' => 'MH004',
                'ten_mon' => 'Lập trình Web với Laravel',
                'so_tin_chi' => 3,
                'mo_ta' => 'Học cách xây dựng ứng dụng web hiện đại sử dụng framework Laravel, bao gồm MVC, routing, migration và Eloquent ORM.',
                'loai_mon' => 'Tự chọn',
                'hinh_thuc_day' => 'online',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
            [
                'ma_mon' => 'MH005',
                'ten_mon' => 'Phân tích và thiết kế hệ thống thông tin',
                'so_tin_chi' => 3,
                'mo_ta' => 'Trang bị kiến thức về quy trình phát triển phần mềm, UML, sơ đồ ca sử dụng và thiết kế hệ thống.',
                'loai_mon' => 'Bắt buộc',
                'hinh_thuc_day' => 'hybrid',
                'thoi_luong' => 50,
                'so_buoi' => 16,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mon_hoc')->insert([
            [
                'ma_mon' => 'CT101',
                'ten_mon' => 'Lập Trình Cơ Bản',
                'so_tin_chi' => 3,
                'mo_ta' => 'Môn học giới thiệu về ngôn ngữ lập trình và cấu trúc cơ bản của chương trình.',
                'loai_mon' => 'Bắt buộc',
                'hinh_thuc_day' => 'offline',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
            [
                'ma_mon' => 'CT102',
                'ten_mon' => 'Cấu Trúc Dữ Liệu & Giải Thuật',
                'so_tin_chi' => 3,
                'mo_ta' => 'Học về các cấu trúc dữ liệu cơ bản như danh sách, cây, đồ thị và các thuật toán sắp xếp, tìm kiếm.',
                'loai_mon' => 'Bắt buộc',
                'hinh_thuc_day' => 'hybrid',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
            [
                'ma_mon' => 'CT103',
                'ten_mon' => 'Cơ Sở Dữ Liệu',
                'so_tin_chi' => 3,
                'mo_ta' => 'Giới thiệu khái niệm cơ bản về hệ quản trị cơ sở dữ liệu và SQL.',
                'loai_mon' => 'Bắt buộc',
                'hinh_thuc_day' => 'offline',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
            [
                'ma_mon' => 'CT104',
                'ten_mon' => 'Lập Trình Web',
                'so_tin_chi' => 3,
                'mo_ta' => 'Cung cấp kiến thức về HTML, CSS, JavaScript và các framework phổ biến.',
                'loai_mon' => 'Tự chọn',
                'hinh_thuc_day' => 'online',
                'thoi_luong' => 60,
                'so_buoi' => 20,
            ],
            [
                'ma_mon' => 'CT105',
                'ten_mon' => 'Mạng Máy Tính',
                'so_tin_chi' => 3,
                'mo_ta' => 'Tìm hiểu về mô hình OSI, TCP/IP và các giao thức mạng cơ bản.',
                'loai_mon' => 'Bắt buộc',
                'hinh_thuc_day' => 'offline',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
            [
                'ma_mon' => 'CT106',
                'ten_mon' => 'Phân Tích & Thiết Kế Hệ Thống',
                'so_tin_chi' => 3,
                'mo_ta' => 'Giới thiệu các phương pháp phân tích, thiết kế và mô hình hóa hệ thống thông tin.',
                'loai_mon' => 'Tự chọn',
                'hinh_thuc_day' => 'hybrid',
                'thoi_luong' => 60,
                'so_buoi' => 20,
            ],
            [
                'ma_mon' => 'CT107',
                'ten_mon' => 'Trí Tuệ Nhân Tạo',
                'so_tin_chi' => 3,
                'mo_ta' => 'Cung cấp nền tảng về các kỹ thuật AI, machine learning cơ bản.',
                'loai_mon' => 'Tự chọn',
                'hinh_thuc_day' => 'online',
                'thoi_luong' => 45,
                'so_buoi' => 15,
            ],
        ]);
    }
}
?>
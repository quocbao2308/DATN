<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LopHocPhanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lop_hoc_phan')->insert([
            [
                'ma_lop_hp' => 'LHP001',
                'mon_hoc_id' => 1, // giả định môn học id = 1 tồn tại
                'hoc_ky_id' => 1,  // giả định học kỳ id = 1 tồn tại
                'suc_chua' => 50,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'ghi_chu' => 'Lớp học phần cơ bản, học tại phòng A101',
                'trang_thai_lop' => 'dang_hoc',
            ],
            [
                'ma_lop_hp' => 'LHP002',
                'mon_hoc_id' => 2,
                'hoc_ky_id' => 1,
                'suc_chua' => 45,
                'hinh_thuc' => 'hybrid',
                'link_online' => 'https://meet.google.com/abc-def',
                'ghi_chu' => 'Học kết hợp trực tiếp và trực tuyến',
                'trang_thai_lop' => 'mo_dang_ky',
            ],
            [
                'ma_lop_hp' => 'LHP003',
                'mon_hoc_id' => 3,
                'hoc_ky_id' => 2,
                'suc_chua' => 60,
                'hinh_thuc' => 'online',
                'link_online' => 'https://zoom.us/j/1234567890',
                'ghi_chu' => 'Lớp online toàn bộ học qua Zoom',
                'trang_thai_lop' => 'ket_thuc',
            ],
            [
                'ma_lop_hp' => 'LHP004',
                'mon_hoc_id' => 4,
                'hoc_ky_id' => 2,
                'suc_chua' => 55,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'ghi_chu' => 'Lớp học tại phòng B201, do thầy Hùng phụ trách',
                'trang_thai_lop' => 'mo_dang_ky',
            ],
        ]);
    }
}

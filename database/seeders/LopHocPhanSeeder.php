<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LopHocPhanSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy ID thực tế từ database
        $monHoc1 = DB::table('mon_hoc')->where('ma_mon', 'CT101')->first();
        $monHoc2 = DB::table('mon_hoc')->where('ma_mon', 'MH002')->first();
        $monHoc3 = DB::table('mon_hoc')->where('ma_mon', 'MH003')->first();
        $monHoc4 = DB::table('mon_hoc')->where('ma_mon', 'MH004')->first();

        $hocKy1 = DB::table('hoc_ky')->orderBy('id')->first();
        $hocKy2 = DB::table('hoc_ky')->orderBy('id')->skip(1)->first();

        if (!$monHoc1 || !$monHoc2 || !$monHoc3 || !$monHoc4) {
            $this->command->error('Vui lòng chạy MonHocSeeder trước!');
            return;
        }

        if (!$hocKy1 || !$hocKy2) {
            $this->command->error('Vui lòng chạy HocKySeeder trước!');
            return;
        }

        DB::table('lop_hoc_phan')->insert([
            [
                'ma_lop_hp' => 'LHP001',
                'mon_hoc_id' => $monHoc1->id,
                'hoc_ky_id' => $hocKy1->id,
                'suc_chua' => 50,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'ghi_chu' => 'Lớp học phần cơ bản, học tại phòng A101',
                'trang_thai_lop' => 'dang_hoc',
            ],
            [
                'ma_lop_hp' => 'LHP002',
                'mon_hoc_id' => $monHoc2->id,
                'hoc_ky_id' => $hocKy1->id,
                'suc_chua' => 45,
                'hinh_thuc' => 'hybrid',
                'link_online' => 'https://meet.google.com/abc-def',
                'ghi_chu' => 'Học kết hợp trực tiếp và trực tuyến',
                'trang_thai_lop' => 'mo_dang_ky',
            ],
            [
                'ma_lop_hp' => 'LHP003',
                'mon_hoc_id' => $monHoc3->id,
                'hoc_ky_id' => $hocKy2->id,
                'suc_chua' => 60,
                'hinh_thuc' => 'online',
                'link_online' => 'https://zoom.us/j/1234567890',
                'ghi_chu' => 'Lớp online toàn bộ học qua Zoom',
                'trang_thai_lop' => 'ket_thuc',
            ],
            [
                'ma_lop_hp' => 'LHP004',
                'mon_hoc_id' => $monHoc4->id,
                'hoc_ky_id' => $hocKy2->id,
                'suc_chua' => 55,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'ghi_chu' => 'Lớp học tại phòng B201, do thầy Hùng phụ trách',
                'trang_thai_lop' => 'mo_dang_ky',
            ],
        ]);

        $this->command->info('Đã thêm ' . count([1, 2, 3, 4]) . ' lớp học phần mẫu!');
    }
}

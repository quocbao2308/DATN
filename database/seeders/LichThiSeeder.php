<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichThiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lich_thi')->insert([
            [
                'lop_hoc_phan_id' => 4,
                'ngay_thi' => '2025-12-10',
                'gio_bat_dau' => '08:00:00',
                'gio_ket_thuc' => '10:00:00',
                'phong_hoc_id' => 1,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'file_pdf' => null,
                'ngay_gui' => Carbon::now(),
            ],
            [
                'lop_hoc_phan_id' => 3,
                'ngay_thi' => '2025-12-11',
                'gio_bat_dau' => '13:30:00',
                'gio_ket_thuc' => '15:30:00',
                'phong_hoc_id' => 2,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'file_pdf' => null,
                'ngay_gui' => Carbon::now(),
            ],
            [
                'lop_hoc_phan_id' => 1,
                'ngay_thi' => '2025-12-12',
                'gio_bat_dau' => '09:00:00',
                'gio_ket_thuc' => '11:00:00',
                'phong_hoc_id' => 3,
                'hinh_thuc' => 'online',
                'link_online' => 'https://meet.google.com/abc-xyz-123',
                'file_pdf' => 'lichthi_2025_12_12.pdf',
                'ngay_gui' => Carbon::now(),
            ],
            [
                'lop_hoc_phan_id' => 2,
                'ngay_thi' => '2025-12-13',
                'gio_bat_dau' => '07:30:00',
                'gio_ket_thuc' => '09:30:00',
                'phong_hoc_id' => 4,
                'hinh_thuc' => 'hybrid',
                'link_online' => 'https://zoom.us/j/999888777',
                'file_pdf' => null,
                'ngay_gui' => Carbon::now(),
            ],
            [
                'lop_hoc_phan_id' => 4,
                'ngay_thi' => '2025-12-14',
                'gio_bat_dau' => '10:00:00',
                'gio_ket_thuc' => '12:00:00',
                'phong_hoc_id' => 5,
                'hinh_thuc' => 'offline',
                'link_online' => null,
                'file_pdf' => null,
                'ngay_gui' => Carbon::now(),
            ],
            [
                'lop_hoc_phan_id' => 2,
                'ngay_thi' => '2025-12-15',
                'gio_bat_dau' => '14:00:00',
                'gio_ket_thuc' => '16:00:00',
                'phong_hoc_id' => 6,
                'hinh_thuc' => 'online',
                'link_online' => 'https://meet.google.com/exam-2025',
                'file_pdf' => 'de_thi_online_2025.pdf',
                'ngay_gui' => Carbon::now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy ID động từ các bảng liên quan
        $lopHocPhans = DB::table('lop_hoc_phan')->pluck('id')->toArray();
        $phongHocs = DB::table('phong_hoc')->pluck('id')->toArray();
        $giangViens = DB::table('giang_vien')->pluck('id')->toArray();

        if (empty($lopHocPhans) || empty($phongHocs) || empty($giangViens)) {
            echo "⚠️  Thiếu dữ liệu: Lớp học phần, Phòng học hoặc Giảng viên!\n";
            return;
        }

        echo "🎯 Bắt đầu tạo dữ liệu lịch học...\n";

        $data = [];
        $startDate = Carbon::now();
        $hinhThucs = ['offline', 'online', 'hybrid'];

        // Tạo 30 bản ghi lịch học với thời gian và phòng khác nhau để tránh trùng unique
        for ($i = 0; $i < 30; $i++) {
            $ngay = $startDate->copy()->addDays($i % 10); // Chia đều trong 10 ngày
            $gioBatDau = sprintf('%02d:%s:00', 7 + ($i % 8), ($i % 2) ? '00' : '30');
            $hour = intval(substr($gioBatDau, 0, 2));
            $gioKetThuc = sprintf('%02d:%s:00', $hour + 2, substr($gioBatDau, 3, 2));
            $hinhThuc = $hinhThucs[array_rand($hinhThucs)];

            $data[] = [
                'lop_hoc_phan_id' => $lopHocPhans[array_rand($lopHocPhans)],
                'ngay' => $ngay->format('Y-m-d'),
                'gio_bat_dau' => $gioBatDau,
                'gio_ket_thuc' => $gioKetThuc,
                'phong_hoc_id' => $phongHocs[$i % count($phongHocs)], // Luân phiên phòng
                'hinh_thuc_buoi_hoc' => $hinhThuc,
                'link_online' => ($hinhThuc != 'offline') ? 'https://meet.google.com/abc-' . $i : null,
                'giang_vien_phu_trach' => $giangViens[array_rand($giangViens)],
                'ghi_chu' => 'Buổi học số ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert với insertOrIgnore để bỏ qua lỗi unique
        DB::table('lich_hoc')->insertOrIgnore($data);

        $inserted = DB::table('lich_hoc')->count();
        echo "✅ Đã tạo {$inserted} bản ghi lịch học!\n";

        // Thống kê
        $offline = DB::table('lich_hoc')->where('hinh_thuc_buoi_hoc', 'offline')->count();
        $online = DB::table('lich_hoc')->where('hinh_thuc_buoi_hoc', 'online')->count();
        $hybrid = DB::table('lich_hoc')->where('hinh_thuc_buoi_hoc', 'hybrid')->count();

        echo "📊 Thống kê:\n";
        echo "   - Offline: {$offline}\n";
        echo "   - Online: {$online}\n";
        echo "   - Hybrid: {$hybrid}\n";
    }
}

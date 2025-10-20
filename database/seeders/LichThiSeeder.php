<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichThiSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy các lớp học phần để tạo lịch thi
        $lopHocPhans = DB::table('lop_hoc_phan')->limit(10)->get();

        if ($lopHocPhans->isEmpty()) {
            echo "⚠️  Chưa có dữ liệu lớp học phần. Vui lòng chạy LopHocPhanSeeder trước!\n";
            return;
        }

        $phongHocs = DB::table('phong_hoc')->pluck('id')->toArray();

        if (empty($phongHocs)) {
            echo "⚠️  Chưa có dữ liệu phòng học. Vui lòng chạy PhongHocSeeder trước!\n";
            return;
        }

        echo "🎯 Bắt đầu tạo dữ liệu lịch thi...\n";

        $hinhThucs = ['offline', 'online', 'hybrid'];
        $lichThiData = [];
        $startDate = Carbon::now()->addDays(30); // Thi sau 30 ngày

        foreach ($lopHocPhans as $index => $lopHocPhan) {
            $hinhThuc = $hinhThucs[array_rand($hinhThucs)];
            $ngayThi = $startDate->copy()->addDays($index * 2); // Cách nhau 2 ngày

            $lichThiData[] = [
                'lop_hoc_phan_id' => $lopHocPhan->id,
                'ngay_thi' => $ngayThi->format('Y-m-d'),
                'gio_bat_dau' => $this->getRandomTime(),
                'gio_ket_thuc' => $this->getRandomTime(true),
                'phong_hoc_id' => $phongHocs[array_rand($phongHocs)],
                'hinh_thuc' => $hinhThuc,
                'link_online' => ($hinhThuc != 'offline') ? $this->getRandomLink() : null,
                'file_pdf' => rand(0, 1) ? 'de_thi_' . $lopHocPhan->id . '.pdf' : null,
                'ngay_gui' => Carbon::now(),
            ];
        }

        DB::table('lich_thi')->insert($lichThiData);

        echo "✅ Đã tạo " . count($lichThiData) . " lịch thi!\n";

        // Thống kê
        $offline = collect($lichThiData)->where('hinh_thuc', 'offline')->count();
        $online = collect($lichThiData)->where('hinh_thuc', 'online')->count();
        $hybrid = collect($lichThiData)->where('hinh_thuc', 'hybrid')->count();

        echo "📊 Thống kê:\n";
        echo "   - Thi offline: {$offline}\n";
        echo "   - Thi online: {$online}\n";
        echo "   - Thi hybrid: {$hybrid}\n";
    }

    private function getRandomTime($isEnd = false)
    {
        $hours = $isEnd ? [10, 11, 12, 15, 16, 17] : [7, 8, 9, 13, 14, 15];
        $hour = $hours[array_rand($hours)];
        $minutes = ['00', '30'];
        return sprintf('%02d:%s:00', $hour, $minutes[array_rand($minutes)]);
    }

    private function getRandomLink()
    {
        $links = [
            'https://meet.google.com/exam-' . rand(100, 999),
            'https://zoom.us/j/' . rand(100000000, 999999999),
            'https://teams.microsoft.com/exam-' . rand(1000, 9999),
        ];
        return $links[array_rand($links)];
    }
}

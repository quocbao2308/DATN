<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SinhVienLopHocPhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinhViens = DB::table('sinh_vien')->pluck('id')->toArray();
        $lopHocPhans = DB::table('lop_hoc_phan')->pluck('id')->toArray();

        if (empty($sinhViens) || empty($lopHocPhans)) {
            echo "⚠️  Thiếu dữ liệu sinh viên hoặc lớp học phần!\n";
            return;
        }

        echo "🎯 Bắt đầu gán sinh viên vào lớp học phần...\n";

        $data = [];

        // Mỗi lớp học phần có 3-5 sinh viên
        foreach ($lopHocPhans as $lopHocPhanId) {
            $soSinhVien = rand(3, min(5, count($sinhViens)));
            $selectedSinhViens = array_rand(array_flip($sinhViens), $soSinhVien);

            if (!is_array($selectedSinhViens)) {
                $selectedSinhViens = [$selectedSinhViens];
            }

            foreach ($selectedSinhViens as $sinhVienId) {
                $data[] = [
                    'sinh_vien_id' => $sinhVienId,
                    'lop_hoc_phan_id' => $lopHocPhanId,
                ];
            }
        }

        DB::table('sinh_vien_lop_hoc_phan')->insertOrIgnore($data);

        $inserted = DB::table('sinh_vien_lop_hoc_phan')->count();
        echo "✅ Đã gán {$inserted} sinh viên vào các lớp học phần!\n";
    }
}

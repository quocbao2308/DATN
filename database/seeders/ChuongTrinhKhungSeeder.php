<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChuongTrinhKhungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy ID thực tế từ database (chỉ lấy môn học chưa bị soft delete)
        $chuyenNganhs = DB::table('chuyen_nganh')->get();
        $monHocs = DB::table('mon_hoc')->whereNull('deleted_at')->get();

        if ($chuyenNganhs->isEmpty() || $monHocs->isEmpty()) {
            $this->command->error('Vui lòng chạy ChuyenNganhSeeder và MonHocSeeder trước!');
            return;
        }

        // Lấy 2 chuyên ngành đầu tiên để test
        $chuyenNganh1 = $chuyenNganhs->first();
        $chuyenNganh2 = $chuyenNganhs->count() > 1 ? $chuyenNganhs->skip(1)->first() : $chuyenNganh1;

        $data = [];

        // Chương trình khung cho Chuyên ngành 1
        if ($chuyenNganh1) {
            $count = 0;
            foreach ($monHocs as $monHoc) {
                if ($count >= 10) break; // Chỉ lấy 10 môn đầu

                $hocKy = ($count % 8) + 1; // Phân bổ đều từ kỳ 1-8
                $loaiMon = match ($count % 3) {
                    0 => 'Bắt buộc',
                    1 => 'Chuyên ngành bắt buộc',
                    2 => 'Tự chọn',
                };

                // Kiểm tra xem môn học này đã tồn tại trong chương trình khung chưa
                $exists = DB::table('chuong_trinh_khung')
                    ->where('chuyen_nganh_id', $chuyenNganh1->id)
                    ->where('mon_hoc_id', $monHoc->id)
                    ->exists();

                if (!$exists) {
                    $data[] = [
                        'chuyen_nganh_id' => $chuyenNganh1->id,
                        'mon_hoc_id' => $monHoc->id,
                        'hoc_ky_goi_y' => $hocKy,
                        'loai_mon_hoc' => $loaiMon,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $count++;
                }
            }
        }

        // Chương trình khung cho Chuyên ngành 2 (nếu khác chuyên ngành 1)
        if ($chuyenNganh2 && $chuyenNganh2->id !== $chuyenNganh1->id) {
            $count = 0;
            foreach ($monHocs->skip(5)->take(8) as $monHoc) {
                $hocKy = ($count % 8) + 1;
                $loaiMon = match ($count % 3) {
                    0 => 'Bắt buộc',
                    1 => 'Tự chọn',
                    2 => 'Chuyên ngành bắt buộc',
                };

                // Kiểm tra xem môn học này đã tồn tại trong chương trình khung chưa
                $exists = DB::table('chuong_trinh_khung')
                    ->where('chuyen_nganh_id', $chuyenNganh2->id)
                    ->where('mon_hoc_id', $monHoc->id)
                    ->exists();

                if (!$exists) {
                    $data[] = [
                        'chuyen_nganh_id' => $chuyenNganh2->id,
                        'mon_hoc_id' => $monHoc->id,
                        'hoc_ky_goi_y' => $hocKy,
                        'loai_mon_hoc' => $loaiMon,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $count++;
                }
            }
        }

        // Insert dữ liệu
        DB::table('chuong_trinh_khung')->insert($data);

        $this->command->info('Đã thêm ' . count($data) . ' bản ghi chương trình khung!');
    }
}

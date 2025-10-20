<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HocPhi\HocPhi;
use App\Models\NhanSu\SinhVien;
use App\Models\HeThong\HocKy;
use Carbon\Carbon;

class HocPhiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách sinh viên và học kỳ
        $sinhViens = SinhVien::all();
        $hocKys = HocKy::orderBy('id', 'desc')->take(3)->get(); // Lấy 3 học kỳ gần nhất

        if ($sinhViens->isEmpty() || $hocKys->isEmpty()) {
            $this->command->warn('Chưa có dữ liệu sinh viên hoặc học kỳ. Vui lòng chạy seeder trước!');
            return;
        }

        $this->command->info('Bắt đầu tạo dữ liệu học phí...');

        $trangThais = ['chua_nop', 'da_nop', 'no'];
        $hocPhiData = [];

        foreach ($hocKys as $hocKy) {
            foreach ($sinhViens as $sinhVien) {
                // Mỗi sinh viên có học phí cho mỗi học kỳ
                $trangThai = $trangThais[array_rand($trangThais)];
                $soTien = rand(3000000, 8000000); // Từ 3 - 8 triệu VNĐ

                $hocPhiData[] = [
                    'sinh_vien_id' => $sinhVien->id,
                    'hoc_ky_id' => $hocKy->id,
                    'so_tien' => $soTien,
                    'ngay_nop' => $trangThai == 'da_nop'
                        ? Carbon::now()->subDays(rand(1, 60))
                        : null,
                    'trang_thai' => $trangThai,
                    'ghi_chu' => $this->getGhiChu($trangThai),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert dữ liệu
        HocPhi::insert($hocPhiData);

        $this->command->info('✅ Đã tạo ' . count($hocPhiData) . ' bản ghi học phí!');

        // Thống kê
        $tongHocPhi = HocPhi::sum('so_tien');
        $daNop = HocPhi::where('trang_thai', 'da_nop')->count();
        $chuaNop = HocPhi::where('trang_thai', 'chua_nop')->count();
        $no = HocPhi::where('trang_thai', 'no')->count();

        $this->command->info("📊 Thống kê:");
        $this->command->info("   - Tổng số tiền: " . number_format($tongHocPhi) . " VNĐ");
        $this->command->info("   - Đã nộp: {$daNop} bản ghi");
        $this->command->info("   - Chưa nộp: {$chuaNop} bản ghi");
        $this->command->info("   - Nợ: {$no} bản ghi");
    }

    private function getGhiChu($trangThai)
    {
        $ghiChuDaNop = [
            'Đã nộp đầy đủ qua chuyển khoản',
            'Nộp tiền mặt tại phòng tài vụ',
            'Thanh toán online',
            'Đã hoàn thành nghĩa vụ học phí',
        ];

        $ghiChuChuaNop = [
            'Chưa đến hạn nộp',
            'Đang chờ xác nhận từ ngân hàng',
            null,
        ];

        $ghiChuNo = [
            'Quá hạn nộp, cần liên hệ phòng tài vụ',
            'Đang làm thủ tục hoãn học phí',
            'Chưa nộp đủ, còn thiếu một phần',
            'Nợ học phí học kỳ trước',
        ];

        switch ($trangThai) {
            case 'da_nop':
                return $ghiChuDaNop[array_rand($ghiChuDaNop)];
            case 'chua_nop':
                return $ghiChuChuaNop[array_rand($ghiChuChuaNop)];
            case 'no':
                return $ghiChuNo[array_rand($ghiChuNo)];
            default:
                return null;
        }
    }
}

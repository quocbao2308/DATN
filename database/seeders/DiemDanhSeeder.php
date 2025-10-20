<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LichHoc\DiemDanh;
use App\Models\LichHoc\LichHoc;
use App\Models\DaoTao\LopHocPhan;
use Illuminate\Support\Facades\DB;

class DiemDanhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các lịch học đã tồn tại
        $lichHocs = LichHoc::with('lopHocPhan')->get();

        if ($lichHocs->isEmpty()) {
            $this->command->warn('Chưa có dữ liệu lịch học. Vui lòng chạy LichHocSeeder trước!');
            return;
        }

        $this->command->info('Bắt đầu tạo dữ liệu điểm danh...');

        $trangThais = ['co_mat', 'vang', 'di_tre', 'nghi_phep'];
        $diemDanhData = [];
        $count = 0;

        foreach ($lichHocs as $lichHoc) {
            // Lấy danh sách sinh viên trong lớp học phần
            $sinhViens = DB::table('sinh_vien_lop_hoc_phan')
                ->where('lop_hoc_phan_id', $lichHoc->lop_hoc_phan_id)
                ->pluck('sinh_vien_id');

            if ($sinhViens->isEmpty()) {
                continue;
            }

            foreach ($sinhViens as $sinhVienId) {
                // Random trạng thái (80% có mặt, 10% vắng, 5% đi trễ, 5% nghỉ phép)
                $rand = rand(1, 100);
                if ($rand <= 80) {
                    $trangThai = 'co_mat';
                } elseif ($rand <= 90) {
                    $trangThai = 'vang';
                } elseif ($rand <= 95) {
                    $trangThai = 'di_tre';
                } else {
                    $trangThai = 'nghi_phep';
                }

                $diemDanhData[] = [
                    'sinh_vien_id' => $sinhVienId,
                    'lich_hoc_id' => $lichHoc->id,
                    'trang_thai' => $trangThai,
                    'ngay_diem_danh' => now(), // Sử dụng thời gian hiện tại
                    'ghi_chu' => $this->getGhiChu($trangThai),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $count++;
            }
        }

        // Insert dữ liệu (có thể chia nhỏ nếu quá lớn)
        if (!empty($diemDanhData)) {
            // Insert theo chunks để tránh quá tải
            $chunks = array_chunk($diemDanhData, 500);
            foreach ($chunks as $chunk) {
                DiemDanh::insert($chunk);
            }

            $this->command->info('✅ Đã tạo ' . $count . ' bản ghi điểm danh!');

            // Thống kê
            $coMat = DiemDanh::where('trang_thai', 'co_mat')->count();
            $vang = DiemDanh::where('trang_thai', 'vang')->count();
            $diTre = DiemDanh::where('trang_thai', 'di_tre')->count();
            $nghiPhep = DiemDanh::where('trang_thai', 'nghi_phep')->count();

            $this->command->info("📊 Thống kê:");
            $this->command->info("   - Có mặt: {$coMat} ({$this->getPercent($coMat,$count)}%)");
            $this->command->info("   - Vắng: {$vang} ({$this->getPercent($vang,$count)}%)");
            $this->command->info("   - Đi trễ: {$diTre} ({$this->getPercent($diTre,$count)}%)");
            $this->command->info("   - Nghỉ phép: {$nghiPhep} ({$this->getPercent($nghiPhep,$count)}%)");
        } else {
            $this->command->warn('Không có sinh viên nào trong các lớp học phần!');
        }
    }

    private function getGhiChu($trangThai)
    {
        $ghiChuCoMat = [null, 'Tham gia đầy đủ', 'Có mặt đúng giờ'];
        $ghiChuVang = ['Vắng không phép', 'Không có lý do', 'Chưa báo trước'];
        $ghiChuDiTre = ['Đến muộn 10 phút', 'Đến muộn 15 phút', 'Tắc đường'];
        $ghiChuNghiPhep = ['Có đơn xin nghỉ', 'Nghỉ ốm', 'Có việc gia đình'];

        switch ($trangThai) {
            case 'co_mat':
                return $ghiChuCoMat[array_rand($ghiChuCoMat)];
            case 'vang':
                return $ghiChuVang[array_rand($ghiChuVang)];
            case 'di_tre':
                return $ghiChuDiTre[array_rand($ghiChuDiTre)];
            case 'nghi_phep':
                return $ghiChuNghiPhep[array_rand($ghiChuNghiPhep)];
            default:
                return null;
        }
    }

    private function getPercent($value, $total)
    {
        return $total > 0 ? round(($value / $total) * 100, 2) : 0;
    }
}

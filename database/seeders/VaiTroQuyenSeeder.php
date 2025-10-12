<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaiTroQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo các vai trò
        $vaiTros = [
            ['id' => 1, 'ten_vai_tro' => 'Admin'],
            ['id' => 2, 'ten_vai_tro' => 'Trưởng Phòng Đào Tạo'],
            ['id' => 3, 'ten_vai_tro' => 'Nhân Viên Đào Tạo'],
            ['id' => 4, 'ten_vai_tro' => 'Giảng Viên Chủ Nhiệm'],
            ['id' => 5, 'ten_vai_tro' => 'Giảng Viên'],
            ['id' => 6, 'ten_vai_tro' => 'Sinh Viên'],
        ];

        foreach ($vaiTros as $vaiTro) {
            DB::table('vai_tro')->insertOrIgnore($vaiTro);
        }

        // 2. Tạo các quyền
        $quyens = [
            // Quản lý người dùng
            ['id' => 1, 'ma_quyen' => 'xem_nguoi_dung', 'mo_ta' => 'Xem danh sách người dùng'],
            ['id' => 2, 'ma_quyen' => 'them_nguoi_dung', 'mo_ta' => 'Thêm người dùng mới'],
            ['id' => 3, 'ma_quyen' => 'sua_nguoi_dung', 'mo_ta' => 'Sửa thông tin người dùng'],
            ['id' => 4, 'ma_quyen' => 'xoa_nguoi_dung', 'mo_ta' => 'Xóa người dùng'],

            // Quản lý sinh viên
            ['id' => 5, 'ma_quyen' => 'xem_sinh_vien', 'mo_ta' => 'Xem danh sách sinh viên'],
            ['id' => 6, 'ma_quyen' => 'them_sinh_vien', 'mo_ta' => 'Thêm sinh viên mới'],
            ['id' => 7, 'ma_quyen' => 'sua_sinh_vien', 'mo_ta' => 'Sửa thông tin sinh viên'],
            ['id' => 8, 'ma_quyen' => 'xoa_sinh_vien', 'mo_ta' => 'Xóa sinh viên'],

            // Quản lý giảng viên
            ['id' => 9, 'ma_quyen' => 'xem_giang_vien', 'mo_ta' => 'Xem danh sách giảng viên'],
            ['id' => 10, 'ma_quyen' => 'them_giang_vien', 'mo_ta' => 'Thêm giảng viên mới'],
            ['id' => 11, 'ma_quyen' => 'sua_giang_vien', 'mo_ta' => 'Sửa thông tin giảng viên'],
            ['id' => 12, 'ma_quyen' => 'xoa_giang_vien', 'mo_ta' => 'Xóa giảng viên'],

            // Quản lý điểm
            ['id' => 13, 'ma_quyen' => 'xem_diem', 'mo_ta' => 'Xem điểm sinh viên'],
            ['id' => 14, 'ma_quyen' => 'nhap_diem', 'mo_ta' => 'Nhập điểm sinh viên'],
            ['id' => 15, 'ma_quyen' => 'sua_diem', 'mo_ta' => 'Sửa điểm sinh viên'],
            ['id' => 16, 'ma_quyen' => 'xoa_diem', 'mo_ta' => 'Xóa điểm sinh viên'],

            // Quản lý lớp học
            ['id' => 17, 'ma_quyen' => 'xem_lop_hoc', 'mo_ta' => 'Xem danh sách lớp học'],
            ['id' => 18, 'ma_quyen' => 'them_lop_hoc', 'mo_ta' => 'Thêm lớp học mới'],
            ['id' => 19, 'ma_quyen' => 'sua_lop_hoc', 'mo_ta' => 'Sửa thông tin lớp học'],
            ['id' => 20, 'ma_quyen' => 'xoa_lop_hoc', 'mo_ta' => 'Xóa lớp học'],

            // Quản lý lịch học
            ['id' => 21, 'ma_quyen' => 'xem_lich_hoc', 'mo_ta' => 'Xem lịch học'],
            ['id' => 22, 'ma_quyen' => 'them_lich_hoc', 'mo_ta' => 'Thêm lịch học'],
            ['id' => 23, 'ma_quyen' => 'sua_lich_hoc', 'mo_ta' => 'Sửa lịch học'],
            ['id' => 24, 'ma_quyen' => 'xoa_lich_hoc', 'mo_ta' => 'Xóa lịch học'],

            // Quản lý danh mục
            ['id' => 25, 'ma_quyen' => 'quan_ly_khoa', 'mo_ta' => 'Quản lý khoa'],
            ['id' => 26, 'ma_quyen' => 'quan_ly_nganh', 'mo_ta' => 'Quản lý ngành'],
            ['id' => 27, 'ma_quyen' => 'quan_ly_mon_hoc', 'mo_ta' => 'Quản lý môn học'],

            // Báo cáo
            ['id' => 28, 'ma_quyen' => 'xem_bao_cao', 'mo_ta' => 'Xem báo cáo thống kê'],
            ['id' => 29, 'ma_quyen' => 'xuat_bao_cao', 'mo_ta' => 'Xuất báo cáo'],

            // Cài đặt hệ thống
            ['id' => 30, 'ma_quyen' => 'cai_dat_he_thong', 'mo_ta' => 'Cài đặt hệ thống'],
        ];

        foreach ($quyens as $quyen) {
            DB::table('quyen')->insertOrIgnore($quyen);
        }

        // 3. Gán quyền cho vai trò
        $vaiTroQuyens = [
            // Admin - Tất cả quyền (bao gồm cài đặt hệ thống)
            ...array_map(fn($i) => ['vai_tro_id' => 1, 'quyen_id' => $i], range(1, 30)),

            // Trưởng Phòng Đào Tạo - Quản lý đào tạo đầy đủ
            ['vai_tro_id' => 2, 'quyen_id' => 5],  // xem_sinh_vien
            ['vai_tro_id' => 2, 'quyen_id' => 6],  // them_sinh_vien
            ['vai_tro_id' => 2, 'quyen_id' => 7],  // sua_sinh_vien
            ['vai_tro_id' => 2, 'quyen_id' => 8],  // xoa_sinh_vien
            ['vai_tro_id' => 2, 'quyen_id' => 9],  // xem_giang_vien
            ['vai_tro_id' => 2, 'quyen_id' => 13], // xem_diem
            ['vai_tro_id' => 2, 'quyen_id' => 14], // nhap_diem
            ['vai_tro_id' => 2, 'quyen_id' => 15], // sua_diem
            ['vai_tro_id' => 2, 'quyen_id' => 17], // xem_lop_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 18], // them_lop_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 19], // sua_lop_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 21], // xem_lich_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 22], // them_lich_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 23], // sua_lich_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 25], // quan_ly_khoa
            ['vai_tro_id' => 2, 'quyen_id' => 26], // quan_ly_nganh
            ['vai_tro_id' => 2, 'quyen_id' => 27], // quan_ly_mon_hoc
            ['vai_tro_id' => 2, 'quyen_id' => 28], // xem_bao_cao
            ['vai_tro_id' => 2, 'quyen_id' => 29], // xuat_bao_cao

            // Nhân Viên Đào Tạo - Chỉ xem và sửa
            ['vai_tro_id' => 3, 'quyen_id' => 5],  // xem_sinh_vien
            ['vai_tro_id' => 3, 'quyen_id' => 7],  // sua_sinh_vien
            ['vai_tro_id' => 3, 'quyen_id' => 9],  // xem_giang_vien
            ['vai_tro_id' => 3, 'quyen_id' => 13], // xem_diem
            ['vai_tro_id' => 3, 'quyen_id' => 17], // xem_lop_hoc
            ['vai_tro_id' => 3, 'quyen_id' => 21], // xem_lich_hoc
            ['vai_tro_id' => 3, 'quyen_id' => 28], // xem_bao_cao

            // Giảng Viên Chủ Nhiệm - Quản lý lớp của mình
            ['vai_tro_id' => 4, 'quyen_id' => 5],  // xem_sinh_vien
            ['vai_tro_id' => 4, 'quyen_id' => 7],  // sua_sinh_vien (lớp mình)
            ['vai_tro_id' => 4, 'quyen_id' => 13], // xem_diem
            ['vai_tro_id' => 4, 'quyen_id' => 14], // nhap_diem
            ['vai_tro_id' => 4, 'quyen_id' => 15], // sua_diem
            ['vai_tro_id' => 4, 'quyen_id' => 17], // xem_lop_hoc
            ['vai_tro_id' => 4, 'quyen_id' => 21], // xem_lich_hoc
            ['vai_tro_id' => 4, 'quyen_id' => 22], // them_lich_hoc
            ['vai_tro_id' => 4, 'quyen_id' => 23], // sua_lich_hoc

            // Giảng Viên - Chỉ xem và nhập điểm
            ['vai_tro_id' => 5, 'quyen_id' => 5],  // xem_sinh_vien
            ['vai_tro_id' => 5, 'quyen_id' => 13], // xem_diem
            ['vai_tro_id' => 5, 'quyen_id' => 14], // nhap_diem
            ['vai_tro_id' => 5, 'quyen_id' => 17], // xem_lop_hoc
            ['vai_tro_id' => 5, 'quyen_id' => 21], // xem_lich_hoc

            // Sinh Viên - Chỉ xem thông tin cá nhân
            ['vai_tro_id' => 6, 'quyen_id' => 13], // xem_diem (của mình)
            ['vai_tro_id' => 6, 'quyen_id' => 21], // xem_lich_hoc (của mình)
        ];

        foreach ($vaiTroQuyens as $vaiTroQuyen) {
            DB::table('vai_tro_quyen')->insertOrIgnore($vaiTroQuyen);
        }

        $this->command->info('✅ Đã seed dữ liệu vai trò và quyền thành công!');
    }
}

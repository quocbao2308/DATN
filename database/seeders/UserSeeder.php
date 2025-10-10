<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo User và Admin
        $adminUser = User::create([
            'name' => 'Admin System',
            'email' => 'admin@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        DB::table('admin')->insert([
            'ho_ten' => 'Admin System',
            'email' => 'admin@smis.edu.vn',
            'so_dien_thoai' => '0123456789',
            'user_id' => $adminUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Tạo User và Đào tạo
        $daoTaoUser = User::create([
            'name' => 'Phòng Đào Tạo',
            'email' => 'daotao@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        DB::table('dao_tao')->insert([
            'ho_ten' => 'Phòng Đào Tạo',
            'email' => 'daotao@smis.edu.vn',
            'so_dien_thoai' => '0123456790',
            'user_id' => $daoTaoUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Tạo User và Giảng viên
        $giangVienUser = User::create([
            'name' => 'TS. Nguyễn Văn A',
            'email' => 'giangvien@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        // Lấy Khoa Công nghệ thông tin
        $khoaCNTT = DB::table('khoa')->where('ten_khoa', 'Khoa Công nghệ thông tin')->first();

        // Lấy trình độ Tiến sĩ
        $trinhDoTienSi = DB::table('dm_trinh_do')->where('ten_trinh_do', 'Tiến sĩ')->first();
        if (!$trinhDoTienSi) {
            $trinhDoTienSi = DB::table('dm_trinh_do')->first();
        }

        DB::table('giang_vien')->insert([
            'ma_giang_vien' => 'GV001',
            'ho_ten' => 'TS. Nguyễn Văn A',
            'email' => 'giangvien@smis.edu.vn',
            'so_dien_thoai' => '0987654321',
            'trinh_do_id' => $trinhDoTienSi->id,
            'chuyen_mon' => 'Công nghệ phần mềm',
            'khoa_id' => $khoaCNTT->id,
            'ngay_vao_truong' => '2015-09-01',
            'user_id' => $giangVienUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Tạo User và Sinh viên
        $sinhVienUser = User::create([
            'name' => 'Trần Văn B',
            'email' => 'sinhvien@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        // Lấy Ngành: Công nghệ thông tin (thuộc Khoa CNTT)
        $nganhCNTT = DB::table('nganh')
            ->where('ten_nganh', 'Công nghệ thông tin')
            ->where('khoa_id', $khoaCNTT->id)
            ->first();

        // Lấy Chuyên ngành: Phát triển phần mềm (thuộc Ngành CNTT)
        $chuyenNganhPTPM = DB::table('chuyen_nganh')
            ->where('ten_chuyen_nganh', 'Phát triển phần mềm')
            ->where('nganh_id', $nganhCNTT->id)
            ->first();

        // Lấy Khóa học K52 (2024-2028)
        $khoaHoc = DB::table('khoa_hoc')->where('ten_khoa_hoc', 'K52')->first();

        // Lấy trạng thái Đang học
        $trangThaiDangHoc = DB::table('trang_thai_hoc_tap')
            ->where('ten_trang_thai', 'Đang học')
            ->first();

        DB::table('sinh_vien')->insert([
            'ma_sinh_vien' => 'PH56835',
            'ho_ten' => 'Trần Văn B',
            'email' => 'sinhvien@smis.edu.vn',
            'so_dien_thoai' => '0912345678',
            'ngay_sinh' => '2003-05-15',
            'gioi_tinh' => 'nam',
            'so_nha_duong' => '123 Trần Đại Nghĩa',
            'phuong_xa' => 'Hai Bà Trưng',
            'quan_huyen' => 'Hai Bà Trưng',
            'tinh_thanh' => 'Hà Nội',
            'nganh_id' => $nganhCNTT->id,
            'chuyen_nganh_id' => $chuyenNganhPTPM->id,
            'khoa_hoc_id' => $khoaHoc->id,
            'ky_hien_tai' => 3,
            'trang_thai_hoc_tap_id' => $trangThaiDangHoc->id,
            'user_id' => $sinhVienUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Đã tạo 4 users:\n";
        echo "   Admin: admin@smis.edu.vn / 123456\n";
        echo "   Đào tạo: daotao@smis.edu.vn / 123456\n";
        echo "   Giảng viên: giangvien@smis.edu.vn / 123456 (TS. Nguyễn Văn A - Khoa CNTT)\n";
        echo "   Sinh viên: sinhvien@smis.edu.vn / 123456 (Trần Văn B - PH56835 - CNTT - K52)\n";

        // Tạo thêm 2 giảng viên từ khoa khác
        $this->createMoreTeachers();

        // Tạo thêm 5 sinh viên từ các khoa khác
        $this->createMoreStudents();
    }

    private function createMoreTeachers()
    {
        // Giảng viên Khoa Kinh tế
        $gvKinhTe = User::create([
            'name' => 'ThS. Lê Thị C',
            'email' => 'lethic@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $khoaKinhTe = DB::table('khoa')->where('ten_khoa', 'Khoa Kinh tế')->first();
        $trinhDoThacSi = DB::table('dm_trinh_do')->where('ten_trinh_do', 'Thạc sĩ')->first();

        DB::table('giang_vien')->insert([
            'ma_giang_vien' => 'GV002',
            'ho_ten' => 'ThS. Lê Thị C',
            'email' => 'lethic@smis.edu.vn',
            'so_dien_thoai' => '0987654322',
            'trinh_do_id' => $trinhDoThacSi->id,
            'chuyen_mon' => 'Kinh tế vĩ mô',
            'khoa_id' => $khoaKinhTe->id,
            'ngay_vao_truong' => '2018-09-01',
            'user_id' => $gvKinhTe->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Giảng viên Khoa Ngoại ngữ
        $gvNgoaiNgu = User::create([
            'name' => 'ThS. Phạm Văn D',
            'email' => 'phamvand@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $khoaNgoaiNgu = DB::table('khoa')->where('ten_khoa', 'Khoa Ngoại ngữ')->first();

        DB::table('giang_vien')->insert([
            'ma_giang_vien' => 'GV003',
            'ho_ten' => 'ThS. Phạm Văn D',
            'email' => 'phamvand@smis.edu.vn',
            'so_dien_thoai' => '0987654323',
            'trinh_do_id' => $trinhDoThacSi->id,
            'chuyen_mon' => 'Ngôn ngữ Anh',
            'khoa_id' => $khoaNgoaiNgu->id,
            'ngay_vao_truong' => '2019-09-01',
            'user_id' => $gvNgoaiNgu->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createMoreStudents()
    {
        $trangThaiDangHoc = DB::table('trang_thai_hoc_tap')->where('ten_trang_thai', 'Đang học')->first();
        $khoaHocK51 = DB::table('khoa_hoc')->where('ten_khoa_hoc', 'K51')->first();
        $khoaHocK52 = DB::table('khoa_hoc')->where('ten_khoa_hoc', 'K52')->first();

        // SV 2: Kinh tế
        $sv2 = User::create([
            'name' => 'Nguyễn Thị E',
            'email' => 'nguyenthie@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $khoaKinhTe = DB::table('khoa')->where('ten_khoa', 'Khoa Kinh tế')->first();
        $nganhKinhTe = DB::table('nganh')->where('ten_nganh', 'Kinh tế học')->where('khoa_id', $khoaKinhTe->id)->first();
        $chuyenNganhKinhTe = DB::table('chuyen_nganh')->where('nganh_id', $nganhKinhTe->id)->first();

        DB::table('sinh_vien')->insert([
            'ma_sinh_vien' => 'PH56001',
            'ho_ten' => 'Nguyễn Thị E',
            'email' => 'nguyenthie@smis.edu.vn',
            'so_dien_thoai' => '0912345679',
            'ngay_sinh' => '2003-03-20',
            'gioi_tinh' => 'nu',
            'tinh_thanh' => 'Hà Nội',
            'nganh_id' => $nganhKinhTe->id,
            'chuyen_nganh_id' => $chuyenNganhKinhTe->id,
            'khoa_hoc_id' => $khoaHocK52->id,
            'ky_hien_tai' => 3,
            'trang_thai_hoc_tap_id' => $trangThaiDangHoc->id,
            'user_id' => $sv2->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // SV 3: Quản trị kinh doanh
        $sv3 = User::create([
            'name' => 'Hoàng Văn F',
            'email' => 'hoangvanf@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $khoaQTKD = DB::table('khoa')->where('ten_khoa', 'Khoa Quản trị kinh doanh')->first();
        $nganhQTKD = DB::table('nganh')->where('ten_nganh', 'Quản trị kinh doanh')->where('khoa_id', $khoaQTKD->id)->first();
        $chuyenNganhQTKD = DB::table('chuyen_nganh')->where('nganh_id', $nganhQTKD->id)->first();

        DB::table('sinh_vien')->insert([
            'ma_sinh_vien' => 'PH56002',
            'ho_ten' => 'Hoàng Văn F',
            'email' => 'hoangvanf@smis.edu.vn',
            'so_dien_thoai' => '0912345680',
            'ngay_sinh' => '2003-07-10',
            'gioi_tinh' => 'nam',
            'tinh_thanh' => 'Hà Nội',
            'nganh_id' => $nganhQTKD->id,
            'chuyen_nganh_id' => $chuyenNganhQTKD->id,
            'khoa_hoc_id' => $khoaHocK52->id,
            'ky_hien_tai' => 3,
            'trang_thai_hoc_tap_id' => $trangThaiDangHoc->id,
            'user_id' => $sv3->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // SV 4: Kế toán
        $sv4 = User::create([
            'name' => 'Vũ Thị G',
            'email' => 'vuthig@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $khoaKeToan = DB::table('khoa')->where('ten_khoa', 'Khoa Kế toán - Kiểm toán')->first();
        $nganhKeToan = DB::table('nganh')->where('ten_nganh', 'Kế toán')->where('khoa_id', $khoaKeToan->id)->first();
        $chuyenNganhKeToan = DB::table('chuyen_nganh')->where('nganh_id', $nganhKeToan->id)->first();

        DB::table('sinh_vien')->insert([
            'ma_sinh_vien' => 'PH55101',
            'ho_ten' => 'Vũ Thị G',
            'email' => 'vuthig@smis.edu.vn',
            'so_dien_thoai' => '0912345681',
            'ngay_sinh' => '2002-11-25',
            'gioi_tinh' => 'nu',
            'tinh_thanh' => 'Hà Nội',
            'nganh_id' => $nganhKeToan->id,
            'chuyen_nganh_id' => $chuyenNganhKeToan->id,
            'khoa_hoc_id' => $khoaHocK51->id,
            'ky_hien_tai' => 5,
            'trang_thai_hoc_tap_id' => $trangThaiDangHoc->id,
            'user_id' => $sv4->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // SV 5: Ngôn ngữ Anh
        $sv5 = User::create([
            'name' => 'Đỗ Văn H',
            'email' => 'dovanh@smis.edu.vn',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        $khoaNgoaiNgu = DB::table('khoa')->where('ten_khoa', 'Khoa Ngoại ngữ')->first();
        $nganhNgoaiNgu = DB::table('nganh')->where('ten_nganh', 'Ngôn ngữ Anh')->where('khoa_id', $khoaNgoaiNgu->id)->first();
        $chuyenNganhNgoaiNgu = DB::table('chuyen_nganh')->where('nganh_id', $nganhNgoaiNgu->id)->first();

        DB::table('sinh_vien')->insert([
            'ma_sinh_vien' => 'PH56003',
            'ho_ten' => 'Đỗ Văn H',
            'email' => 'dovanh@smis.edu.vn',
            'so_dien_thoai' => '0912345682',
            'ngay_sinh' => '2003-09-05',
            'gioi_tinh' => 'nam',
            'tinh_thanh' => 'Hà Nội',
            'nganh_id' => $nganhNgoaiNgu->id,
            'chuyen_nganh_id' => $chuyenNganhNgoaiNgu->id,
            'khoa_hoc_id' => $khoaHocK52->id,
            'ky_hien_tai' => 3,
            'trang_thai_hoc_tap_id' => $trangThaiDangHoc->id,
            'user_id' => $sv5->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Đã tạo thêm:\n";
        echo "   - 2 giảng viên (Kinh tế, Ngoại ngữ)\n";
        echo "   - 5 sinh viên (CNTT, Kinh tế, QTKD, Kế toán, Ngoại ngữ)\n";
    }
}

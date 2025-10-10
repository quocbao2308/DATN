<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChuyenNganhSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Công nghệ thông tin
            ['ten_chuyen_nganh' => 'Phát triển phần mềm', 'nganh_id' => 1],
            ['ten_chuyen_nganh' => 'Phát triển ứng dụng di động', 'nganh_id' => 1],
            ['ten_chuyen_nganh' => 'Quản trị mạng và hệ thống', 'nganh_id' => 1],
            ['ten_chuyen_nganh' => 'Trí tuệ nhân tạo', 'nganh_id' => 1],

            // Kỹ thuật phần mềm
            ['ten_chuyen_nganh' => 'Công nghệ phần mềm', 'nganh_id' => 2],
            ['ten_chuyen_nganh' => 'Kiểm thử phần mềm', 'nganh_id' => 2],
            ['ten_chuyen_nganh' => 'Phân tích và thiết kế hệ thống', 'nganh_id' => 2],

            // Hệ thống thông tin
            ['ten_chuyen_nganh' => 'Quản trị hệ thống thông tin', 'nganh_id' => 3],
            ['ten_chuyen_nganh' => 'Hệ thống thông tin quản lý', 'nganh_id' => 3],
            ['ten_chuyen_nganh' => 'Phân tích dữ liệu', 'nganh_id' => 3],

            // Khoa học máy tính
            ['ten_chuyen_nganh' => 'Học máy', 'nganh_id' => 4],
            ['ten_chuyen_nganh' => 'Thị giác máy tính', 'nganh_id' => 4],
            ['ten_chuyen_nganh' => 'Khoa học dữ liệu', 'nganh_id' => 4],

            // An toàn thông tin
            ['ten_chuyen_nganh' => 'An ninh mạng', 'nganh_id' => 5],
            ['ten_chuyen_nganh' => 'Mật mã học', 'nganh_id' => 5],
            ['ten_chuyen_nganh' => 'Điều tra số', 'nganh_id' => 5],

            // Kinh tế học
            ['ten_chuyen_nganh' => 'Kinh tế vi mô', 'nganh_id' => 6],
            ['ten_chuyen_nganh' => 'Kinh tế toàn cầu', 'nganh_id' => 6],
            ['ten_chuyen_nganh' => 'Kinh tế lượng', 'nganh_id' => 6],

            // Tài chính - Ngân hàng
            ['ten_chuyen_nganh' => 'Tài chính doanh nghiệp', 'nganh_id' => 9],
            ['ten_chuyen_nganh' => 'Ngân hàng', 'nganh_id' => 9],
            ['ten_chuyen_nganh' => 'Bảo hiểm', 'nganh_id' => 9],
            ['ten_chuyen_nganh' => 'Chứng khoán', 'nganh_id' => 9],

            // Quản trị kinh doanh
            ['ten_chuyen_nganh' => 'Quản trị chiến lược', 'nganh_id' => 10],
            ['ten_chuyen_nganh' => 'Quản trị dự án', 'nganh_id' => 10],
            ['ten_chuyen_nganh' => 'Quản trị doanh nghiệp', 'nganh_id' => 10],

            // Marketing
            ['ten_chuyen_nganh' => 'Marketing số', 'nganh_id' => 11],
            ['ten_chuyen_nganh' => 'Thương mại điện tử', 'nganh_id' => 11],
            ['ten_chuyen_nganh' => 'Quản trị thương hiệu', 'nganh_id' => 11],

            // Quản trị nhân lực
            ['ten_chuyen_nganh' => 'Tuyển dụng và đào tạo', 'nganh_id' => 12],
            ['ten_chuyen_nganh' => 'Quản lý lương thưởng', 'nganh_id' => 12],
            ['ten_chuyen_nganh' => 'Phát triển nguồn nhân lực', 'nganh_id' => 12],

            // Logistics
            ['ten_chuyen_nganh' => 'Quản lý kho vận', 'nganh_id' => 13],
            ['ten_chuyen_nganh' => 'Vận tải đa phương thức', 'nganh_id' => 13],
            ['ten_chuyen_nganh' => 'Quản lý chuỗi cung ứng toàn cầu', 'nganh_id' => 13],

            // Kế toán
            ['ten_chuyen_nganh' => 'Kế toán tài chính', 'nganh_id' => 14],
            ['ten_chuyen_nganh' => 'Kế toán quản trị', 'nganh_id' => 14],
            ['ten_chuyen_nganh' => 'Kế toán thuế', 'nganh_id' => 14],

            // Ngôn ngữ Anh
            ['ten_chuyen_nganh' => 'Biên dịch - Phiên dịch', 'nganh_id' => 20],
            ['ten_chuyen_nganh' => 'Ngôn ngữ Anh thương mại', 'nganh_id' => 20],
            ['ten_chuyen_nganh' => 'Giảng dạy tiếng Anh', 'nganh_id' => 20],

            // Kỹ thuật cơ khí
            ['ten_chuyen_nganh' => 'Chế tạo máy', 'nganh_id' => 24],
            ['ten_chuyen_nganh' => 'Cơ kỹ thuật', 'nganh_id' => 24],
            ['ten_chuyen_nganh' => 'Nhiệt lạnh', 'nganh_id' => 24],

            // Kỹ thuật xây dựng
            ['ten_chuyen_nganh' => 'Xây dựng dân dụng', 'nganh_id' => 30],
            ['ten_chuyen_nganh' => 'Xây dựng công nghiệp', 'nganh_id' => 30],
            ['ten_chuyen_nganh' => 'Xây dựng cầu đường', 'nganh_id' => 30],

            // Quản trị khách sạn
            ['ten_chuyen_nganh' => 'Quản lý khách sạn 5 sao', 'nganh_id' => 33],
            ['ten_chuyen_nganh' => 'Nhà hàng - Ẩm thực', 'nganh_id' => 33],
            ['ten_chuyen_nganh' => 'Quản lý sự kiện - Hội nghị', 'nganh_id' => 33],
        ];

        foreach ($data as $item) {
            DB::table('chuyen_nganh')->insert($item);
        }
    }
}

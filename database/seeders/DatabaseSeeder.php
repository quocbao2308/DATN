<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder theo thứ tự phụ thuộc
        // 
        $this->call([
            // 1. Danh mục cơ bản
            KhoaSeeder::class,
            NganhSeeder::class,
            ChuyenNganhSeeder::class,
            DmTrinhDoSeeder::class,
            TrangThaiHocTapSeeder::class,
            KhoaHocSeeder::class,
            HocKySeeder::class,
            MonHocSeeder::class,
            LopHocPhanSeeder::class,
            // Ensure rooms and users (giang_vien) exist before seeding schedules
            PhongHocSeeder::class,
            // 2. Users và phân quyền (creates giang_vien, sinh_vien, admin etc.)
            UserSeeder::class,
            LichHocSeeder::class,
            LichThiSeeder::class,
        ]);
    }
}

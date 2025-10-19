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
            MonHocSeeder::class,
            LichHocSeeder::class,
            LopHocPhanSeeder::class,
            LichThiSeeder::class,
        ]);
    }
}

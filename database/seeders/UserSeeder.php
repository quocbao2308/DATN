<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo user Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@smis.edu.vn',
            'password' => Hash::make('123456'),
        ]);

        // Tạo user Đào tạo
        User::create([
            'name' => 'Phòng Đào Tạo',
            'email' => 'daotao@smis.edu.vn',
            'password' => Hash::make('123456'),
        ]);

        // Tạo user Giảng viên
        User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'giangvien@smis.edu.vn',
            'password' => Hash::make('123456'),
        ]);

        // Tạo user Sinh viên
        User::create([
            'name' => 'Nguyễn Văn B',
            'email' => 'sinhvien@smis.edu.vn',
            'password' => Hash::make('123456'),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DmTrinhDoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trinhDos = [
            ['ten_trinh_do' => 'Cao đẳng'],
            ['ten_trinh_do' => 'Đại học'],
            ['ten_trinh_do' => 'Thạc sĩ'],
            ['ten_trinh_do' => 'Tiến sĩ'],
            ['ten_trinh_do' => 'Liên thông'],
            ['ten_trinh_do' => 'Văn bằng 2'],
        ];

        DB::table('dm_trinh_do')->insert($trinhDos);
    }
}

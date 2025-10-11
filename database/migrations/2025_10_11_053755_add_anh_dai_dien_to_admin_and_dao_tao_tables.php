<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm cột anh_dai_dien vào bảng admin
        Schema::table('admin', function (Blueprint $table) {
            $table->string('anh_dai_dien')->nullable()->after('so_dien_thoai');
        });

        // Thêm cột anh_dai_dien vào bảng dao_tao
        Schema::table('dao_tao', function (Blueprint $table) {
            $table->string('anh_dai_dien')->nullable()->after('phong_ban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa cột anh_dai_dien khỏi bảng admin
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('anh_dai_dien');
        });

        // Xóa cột anh_dai_dien khỏi bảng dao_tao
        Schema::table('dao_tao', function (Blueprint $table) {
            $table->dropColumn('anh_dai_dien');
        });
    }
};

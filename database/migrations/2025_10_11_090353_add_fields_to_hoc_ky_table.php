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
        Schema::table('hoc_ky', function (Blueprint $table) {
            // Drop unique constraint cũ
            $table->dropUnique(['ten_hoc_ky', 'nam_bat_dau', 'nam_ket_thuc']);

            // Thêm trường khoa_hoc_id
            $table->foreignId('khoa_hoc_id')->after('id')->constrained('khoa_hoc')->onDelete('cascade');

            // Thêm trường mo_ta
            $table->text('mo_ta')->nullable()->after('ngay_ket_thuc');

            // Thêm unique constraint mới
            $table->unique(['ten_hoc_ky', 'khoa_hoc_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_ky', function (Blueprint $table) {
            // Drop unique constraint mới
            $table->dropUnique(['ten_hoc_ky', 'khoa_hoc_id']);

            // Drop các trường đã thêm
            $table->dropForeign(['khoa_hoc_id']);
            $table->dropColumn(['khoa_hoc_id', 'mo_ta']);

            // Khôi phục unique constraint cũ
            $table->unique(['ten_hoc_ky', 'nam_bat_dau', 'nam_ket_thuc']);
        });
    }
};

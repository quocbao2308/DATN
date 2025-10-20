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
        // If the table already exists (created by older migration), skip creating it to avoid errors
        if (Schema::hasTable('chuong_trinh_khung')) {
            return;
        }

        Schema::create('chuong_trinh_khung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chuyen_nganh_id')->constrained('chuyen_nganh')->cascadeOnDelete();
            $table->foreignId('mon_hoc_id')->constrained('mon_hoc')->cascadeOnDelete();
            $table->unsignedTinyInteger('hoc_ky_goi_y')->nullable()->comment('Học kỳ gợi ý (1-8)');
            $table->string('loai_mon_hoc')->nullable()->comment('Bắt buộc, Chuyên ngành, Tự chọn');
            $table->timestamps();

            // Unique constraint: một môn chỉ xuất hiện 1 lần trong 1 chuyên ngành
            $table->unique(['chuyen_nganh_id', 'mon_hoc_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuong_trinh_khung');
    }
};

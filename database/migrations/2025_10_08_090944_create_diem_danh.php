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
        Schema::create('diem_danh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinh_vien_id')->constrained('sinh_vien');
            $table->foreignId('lich_hoc_id')->constrained('lich_hoc');
            $table->enum('trang_thai', ['co_mat', 'vang', 'di_tre', 'nghi_phep']);
            $table->dateTime('ngay_diem_danh');
            $table->unique(['sinh_vien_id', 'lich_hoc_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diem_danh');
    }
};

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
        Schema::create('giang_vien', function (Blueprint $table) {
            $table->id();
            $table->string('ma_giang_vien')->unique();
            $table->string('ho_ten');
            $table->string('email')->unique();
            $table->string('so_dien_thoai')->nullable();
            $table->foreignId('trinh_do_id')->constrained('dm_trinh_do');
            $table->string('chuyen_mon')->nullable();
            $table->foreignId('khoa_id')->constrained('khoa');
            $table->date('ngay_vao_truong')->nullable();
            $table->string('anh_dai_dien')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giang_vien');
    }
};

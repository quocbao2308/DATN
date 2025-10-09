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
        Schema::create('sinh_vien', function (Blueprint $table) {
            $table->id();
            $table->string('ma_sinh_vien')->unique();
            $table->string('ho_ten');
            $table->string('email')->unique();
            $table->date('ngay_sinh')->nullable();
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->string('so_nha_duong')->nullable();
            $table->string('phuong_xa')->nullable();
            $table->string('quan_huyen')->nullable();
            $table->string('tinh_thanh')->nullable();
            $table->string('can_cuoc_cong_dan')->unique()->nullable();
            $table->date('ngay_cap_cccd')->nullable();
            $table->string('noi_cap_cccd')->nullable();
            $table->string('anh_dai_dien')->nullable();
            $table->foreignId('khoa_hoc_id')->constrained('khoa_hoc');
            $table->foreignId('nganh_id')->constrained('nganh');
            $table->foreignId('chuyen_nganh_id')->constrained('chuyen_nganh');
            $table->unsignedTinyInteger('ky_hien_tai')->default(1);
            $table->foreignId('trang_thai_hoc_tap_id')->constrained('trang_thai_hoc_tap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinh_vien');
    }
};

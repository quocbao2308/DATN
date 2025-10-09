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
        Schema::create('lich_hoc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lop_hoc_phan_id')->constrained('lop_hoc_phan');
            $table->date('ngay');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->foreignId('phong_hoc_id')->constrained('phong_hoc');
            $table->enum('hinh_thuc_buoi_hoc', ['offline', 'online', 'hybrid']);
            $table->string('link_online')->nullable();
            $table->foreignId('giang_vien_phu_trach')->constrained('giang_vien');
            $table->text('ghi_chu')->nullable();
            $table->unique(['ngay', 'gio_bat_dau', 'phong_hoc_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_hoc');
    }
};

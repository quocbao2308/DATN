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
        Schema::create('lop_hoc_phan', function (Blueprint $table) {
            $table->id();
            $table->string('ma_lop_hp')->unique();
            $table->foreignId('mon_hoc_id')->constrained('mon_hoc');
            $table->foreignId('hoc_ky_id')->constrained('hoc_ky');
            $table->unsignedSmallInteger('suc_chua')->nullable();
            $table->enum('hinh_thuc', ['offline', 'online', 'hybrid']);
            $table->string('link_online')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->enum('trang_thai_lop', ['mo_dang_ky', 'dang_hoc', 'ket_thuc', 'huy']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_hoc_phan');
    }
};

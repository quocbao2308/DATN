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
        Schema::create('dang_ki_mon_hoc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinh_vien_id')->constrained('sinh_vien');
            $table->foreignId('lop_hoc_phan_id')->constrained('lop_hoc_phan');
            $table->dateTime('ngay_dang_ky');
            $table->float('diem_he_10')->nullable();
            $table->float('diem_he_4')->nullable();
            $table->string('diem_chu')->nullable();
            $table->boolean('qua_mon')->default(false);
            $table->unique(['sinh_vien_id', 'lop_hoc_phan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dang_ki_mon_hoc');
    }
};

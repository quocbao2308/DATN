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
        Schema::create('nhap_diem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinh_vien_id')->constrained('sinh_vien');
            $table->foreignId('cau_hinh_id')->constrained('cau_hinh_dau_diem');
            $table->float('diem_so');
            $table->unique(['sinh_vien_id', 'cau_hinh_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhap_diem');
    }
};

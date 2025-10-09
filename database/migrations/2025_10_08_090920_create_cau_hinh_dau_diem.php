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
        Schema::create('cau_hinh_dau_diem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lop_hoc_phan_id')->constrained('lop_hoc_phan');
            $table->string('ten_dau_diem');
            $table->float('ty_le');
            $table->unique(['lop_hoc_phan_id', 'ten_dau_diem']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hinh_dau_diem');
    }
};

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
        Schema::create('lop_hoc_phan_giang_vien', function (Blueprint $table) {
            $table->foreignId('lop_hoc_phan_id')->constrained('lop_hoc_phan');
            $table->foreignId('giang_vien_id')->constrained('giang_vien');
            $table->string('vai_tro')->nullable(); // chính, phụ
            $table->primary(['lop_hoc_phan_id', 'giang_vien_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_hoc_phan_giang_vien');
    }
};

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
        Schema::create('khoa_hoc', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khoa_hoc');
            $table->integer('nam_bat_dau');
            $table->integer('nam_ket_thuc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khoa_hoc');
    }
};

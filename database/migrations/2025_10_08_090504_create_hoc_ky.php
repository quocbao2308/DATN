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
        Schema::create('hoc_ky', function (Blueprint $table) {
            $table->id();
            $table->string('ten_hoc_ky');
            $table->integer('nam_bat_dau');
            $table->integer('nam_ket_thuc');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->unique(['ten_hoc_ky', 'nam_bat_dau', 'nam_ket_thuc']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoc_ky');
    }
};

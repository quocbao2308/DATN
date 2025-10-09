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
        Schema::create('chuong_trinh_khung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chuyen_nganh_id')->constrained('chuyen_nganh');
            $table->foreignId('mon_hoc_id')->constrained('mon_hoc');
            $table->unsignedTinyInteger('hoc_ky_goi_y');
            $table->string('loai_mon_hoc');
            $table->unique(['chuyen_nganh_id', 'mon_hoc_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
